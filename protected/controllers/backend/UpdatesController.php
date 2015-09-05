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
		}
		$this->render('index', [
			'release' => $release,
		]);
	}

	public function actionLatestRelease() {
		Yii::import('application.components.Github');
		$github = new \Github();
		$release = $github->getLatestRelease();
		$result = [];
		if ($release) {
			// "tag_name": "v1.0.0",
			// "created_at": "2013-02-27T19:35:32Z",
			// "assets":
			//   'browser_download_url' => 'https://github.com/wowtransfer/chdphp/releases/download/v1.1/chdphp-v1.1.zip'
			//   'name' => 'chdphp-v1.1.zip'
			// 'zipball_url' => 'https://api.github.com/repos/wowtransfer/chdphp/zipball/v1.1'
			$result['tag_name'] = $release->tag_name;
			$result['created_at'] = $release->created_at;
			if (isset($release->assets)) {
				$asset = $release->assets[0];
				$result['download_url'] = $asset->browser_download_url;
				$result['name'] = $asset->name;
			}
		}
		echo CJSON::encode($result);
	}

	public function actionUploadRelease() {
		$request = Yii::app()->request;

		try {
			$this->uploadArchive();
		} catch (Exception $ex) {
			Yii::app()->user->setFlash('error', $ex->getMessage());
		}

		$this->redirect('index');
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
	protected function uploadArchive() {
		$file = CUploadedFile::getInstanceByName('archive');
		if (!$file) {
			throw new Exception('Файл не загружен');
		}
		if (strtolower($file->extensionName) !== 'zip') {
			throw new Exception('Можно загружать только zip архив');
		}
		$archiveTempFilePath = $this->getTempReleaseFilePath();
		if (!$file->saveAs($archiveTempFilePath)) {
			throw new Exception('Не удалось скопировать загруженный файл');
		}

		// from source code: chdphp.zip => dir => target files
		// from release: chdphp-1.0.zip => chdphp => target files

		$archiveDestDir = self::getReleaseDir();
		$this->clearDir($archiveDestDir);

		$zip = new ZipArchive();
		$openResult = $zip->open($archiveTempFilePath);
		if ($openResult !== true) {
			throw new Exception('Zip open failed, exit code ' . $openResult);
		}
		$zip->extractTo($archiveDestDir);
		$zip->close();

		$sourceReleaseDir = $this->getSourceReleaseDir($archiveDestDir);

		// overwrite files!!!
		$fileHelper = new CFileHelper();

		$webRoot = Yii::getPathOfAlias('webroot');

		var_dump($fileHelper->copyDirectory($sourceReleaseDir, $webRoot));
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
		while ($file = readdir($h)) {
			if ($file !== '.' && $file !== '..') {
				$path = $dir . DIRECTORY_SEPARATOR . $file;
				if (is_dir($path)) {
					$this->clearDir($path, true);
				}
				else {
					unlink($path);
				}
			}
		}
		closedir($h);

		if ($delete) {
			rmdir($dir);
		}

		return true;
	}

	protected function getTempReleaseFilePath() {
		return self::getTempReleaseDir() . DIRECTORY_SEPARATOR . 'release.zip';
	}

	protected function getReleaseFilePath() {
		return self::getReleaseDir() . DIRECTORY_SEPARATOR . 'release';
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