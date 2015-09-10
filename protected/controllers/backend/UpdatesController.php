<?php

class UpdatesController extends BackEndController
{
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

	public function actionIndex()
	{
		$release = [];
		$latestReleaseFilePath = $this->getTempReleaseFilePath();
		if (is_file($latestReleaseFilePath)) {
			$release['size'] = filesize($latestReleaseFilePath);
			$zip = new \ZipArchive();
			if ($zip->open($latestReleaseFilePath)) {
				$names = [];
				for ($i = 0; $i < $zip->numFiles; ++$i) {
					$names[] = $zip->getNameIndex($i);
				}
				$release['file_names'] = $names;
				$zip->close();
			}
		}
		$this->render('index', [
			'release'    => $release,
			'appVersion' => Yii::app()->params['version'],
			'appDate'    => Yii::app()->params['date'],
		]);
	}

	public function actionLatestRelease() {
		$service = new Wowtransfer();
		$service->setAccessToken(Yii::app()->params['accessToken']);
		$service->setBaseUrl(Yii::app()->params['apiBaseUrl']);

		$app = $service->getApplication('chdphp');
		$result = [];
		if ($app) {
			$result['name'] = $app->getName();
			$result['version'] = $app->getVersion();
			$result['updated_at'] = date('Y-m-d', strtotime($app->getUpdatedAt()));
			$result['download_url'] = $app->getDownloadUrl();
		}
		echo CJSON::encode($result);
	}

	public function actionUploadRelease() {
		try {
			// TODO: check
			// ...
			$file = CUploadedFile::getInstanceByName('archive');
			if (!$file) {
				throw new Exception(Yii::t('app', 'File not uploaded'));
			}
			if (strtolower($file->extensionName) !== 'zip') {
				throw new Exception(Yii::t('app', 'The file cannot be uploaded. Only "zip" extension is allowed.'));
			}
			$archiveTempFilePath = $this->getTempReleaseFilePath();
			if (!$file->saveAs($archiveTempFilePath)) {
				throw new Exception(Yii::t('app', 'Could not copy the file') . $archiveTempFilePath);
			}
		} catch (Exception $ex) {
			Yii::app()->user->setFlash('error', $ex->getMessage());
		}

		$this->redirect('index');
	}

	public function actionDownloadLatestRelease() {
		$response = [];
		try {
			$response['success'] = $this->downloadLatestRelease();
			if ($response['success']) {
				$response['success_message'] = Yii::t('app', 'The release has downloaded successfully');
			}
			else {
				$response['error_message'] = Yii::t('app', 'Could not download the file');
			}
		} catch (Exception $ex) {
			$response['error_message'] = $ex->getMessage();
		}
		if (Yii::app()->request->isAjaxRequest) {
			echo json_encode($response);
			Yii::app()->end();
		}
		$this->redirect('index');
	}

	/**
	 * @return boolean
	 * @throws \Exception
	 */
	private function downloadLatestRelease() {
		$service = new Wowtransfer();
		$service->setAccessToken(Yii::app()->params['accessToken']);
		$service->setBaseUrl(Yii::app()->params['apiBaseUrl']);

		$app = $service->getApplication('chdphp');
		if (!$app || !$app->getDownloadUrl()) {
			throw new \Exception(Yii::t('app', 'Could not download the file'));
		}
		$destFileHandle = fopen($this->getTempReleaseFilePath(), 'w');
		if (!$destFileHandle) {
			throw new \Exception(Yii::t('app', 'Could not open the file {file}', [
				'{file}' => $this->getTempReleaseFilePath(),
			]));
		}
		$ch = curl_init();
		$options = [
			CURLOPT_FILE => $destFileHandle,
			CURLOPT_TIMEOUT => 60 * 60, // 1 minute
			CURLOPT_URL => $app->getDownloadUrl()
		];
		curl_setopt_array($ch, $options);
		$result = curl_exec($ch);
		curl_close($ch);
		fclose($destFileHandle);

		return $result;
	}

	public function actionDeleteRelease() {
		$archiveTempFilePath = $this->getTempReleaseFilePath();
		if (is_file($archiveTempFilePath)) {
			unlink($archiveTempFilePath);
		}
		if (Yii::app()->request->isAjaxRequest) {
			Yii::app()->end();
		}
		$this->redirect('index');
	}

	public function actionUpdateApplication() {
		$response = ['success' => true];

		try {
			$action = Yii::app()->request->getPost('action');
			switch ($action) {
				case 'extract':
					$this->updatingExtractRelease();
					$response['next_action'] = 'copy_files';
					break;
				case 'copy_files':
					$this->updatingCopyFiles();
					$response['next_action'] = 'delete_files';
					break;
				case 'delete_files':
					$this->updatingDeleteFiles();
					$response['next_action'] = 'concat';
					break;
				case 'concat':
					$this->updatingConcatResource();
					$response['next_action'] = 'minify';
					break;
				case 'minify':
					$this->updatingMinifyResource();
					$response['next_action'] = 'delete_temp_files';
					break;
				case 'delete_temp_files':
					$this->updatingDeleteTempFiles();
					$response['success'] = true;
					break;
				default:
					throw new \Exception("Unknown action for updating");
			}
		} catch (Exception $ex) {
			unset($response['success']);
			$response['error_message'] = $ex->getMessage();
		}

		echo json_encode($response);
	}

	public function actionReleaseFiles() {
		$filePath = $this->getTempReleaseFilePath();
		if (!is_file($filePath)) {
			return false;
		}
		$response = [];
		$zip = new ZipArchive();
		if ($zip->open($filePath)) {
			for ($i = 0; $i < $zip->numFiles; $i++) {
				$response[] = $zip->getNameIndex($i);
			}
		}
		header('Content type: application/json; ');
		echo json_encode($response);
	}

	/**
	 * @throws Exception
	 */
	protected function updatingExtractRelease() {
		// from source code: chdphp.zip => dir => target files
		// from release:updated_at chdphp-1.0.zip => chdphp => target files

		$archiveDestDir = self::getReleaseDir();
		$this->clearDir($archiveDestDir);

		$zip = new ZipArchive();
		$archiveTempFilePath = $this->getTempReleaseFilePath();
		$openResult = $zip->open($archiveTempFilePath);
		if ($openResult !== true) {
			throw new Exception(Yii::t('app', 'Open of the zip archive are failed, exit code') . ' ' . $openResult);
		}
		$zip->extractTo($archiveDestDir);
		$zip->close();

		return true;
	}

	/**
	 * @return boolean
	 */
	protected function updatingDeleteTempFiles() {
		$archiveDestDir = self::getReleaseDir();
		return $this->clearDir($archiveDestDir, true);
	}

	/**
	 * @return boolean
	 */
	protected function updatingCopyFiles() {
		$destDir = Yii::getPathOfAlias('webroot');
		$sourceDir = self::getReleaseDir();

		$result = true;
		if (!YII_DEBUG) {
			$fileHelper = new CFileHelper();
			$result = $fileHelper->copyDirectory($sourceDir, $destDir, [
				'exclude' => [
					'/install',
				]
			]);
		}

		return $result;
	}

	/**
	 * @return boolean
	 */
	protected function updatingDeleteFiles() {
		return true;
	}

	/**
	 * @return boolean
	 */
	protected function updatingConcatResource() {
		return true;
	}

	/**
	 * @return boolean
	 */
	protected function updatingMinifyResource() {
		return true;
	}

	/**
	 * @param string $dir
	 * @return string
	 */
	private function getSourceReleaseDir($dir) {
		$files = scandir($dir);
		if ($files && count($files) === 3)  {
			return $dir . DIRECTORY_SEPARATOR . $files[2];
		}
		return $dir;
	}

	/**
	 * @param string $dir
	 * @param string $delete
	 * @param integer $level
	 */
	private function clearDir($dir, $delete = false) {
		$h = opendir($dir);
		if (!$h) {
			return false;
		}
		$result = true;
		while ($file = readdir($h)) {
			if ($file !== '.' && $file !== '..') {
				$path = $dir . DIRECTORY_SEPARATOR . $file;
				if (is_dir($path)) {
					$result &= $this->clearDir($path, true);
				}
				else {
					$result &= unlink($path);
				}
			}
		}
		closedir($h);

		if ($delete) {
			$result &= rmdir($dir);
		}

		return $result;
	}

	protected function getTempReleaseFilePath() {
		return self::getTempReleaseDir() . DIRECTORY_SEPARATOR . 'release.zip';
	}

	/**
	 * @return string
	 */
	protected static function getTempReleaseDir() {
		return Yii::getPathOfAlias('application.runtime');
	}

	/**
	 * @return string
	 */
	protected static function getReleaseDir() {
		// TODO: + version, like 1.0.1
		$dir = Yii::getPathOfAlias('application.runtime.release');
		if (!is_dir($dir)) {
			mkdir($dir);
		}
		return $dir;
	}
}