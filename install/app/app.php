<?php
namespace Installer;

include_once __DIR__ . '/view.php';
include_once __DIR__ . '/database.php';

use Installer;

class App
{
	/**
	 * @var Installer\View
	 */
	protected $view;

	/**
	 * @var \Installer\App
	 */
	public static $app;

	/**
	 * @var array
	 */
	private static $messages = [];

	/**
	 * @var string
	 */
	protected $language = 'ru';

	public function __construct()
	{
		$this->view = new View();
		$this->language = isset($_COOKIE['lang']) ? $_COOKIE['lang'] : 'ru';
		// default source language is `EN`
		if ($this->language !== 'en') {
			self::$messages = require __DIR__ . '/messages/' . $this->language . '/app.php';
		}

		self::$app = $this;
	}

	public function run()
	{
		try {

			$pages = $this->getPages();

			$pageName = isset($_GET['page']) ? $_GET['page'] : 'hello';

			$controller = isset($_GET['controller']) ? $_GET['controller'] : '';
			$action = isset($_GET['action']) ? $_GET['action'] : '';

			$this->handleAction($controller, $action);

			if ($this->isInstalled()) {
				$layout = 'installed';
				$pageName = 'installed';
				$pageTitle = 'Приложение уже установлено';
			}
			else {
				$page = key_exists($pageName, $pages) ? $pages[$pageName] : reset($pages);
				$layout = 'main';
				$pageTitle = $page['title'];
				$stepCount = count($pages);

				$this->view->readSubmitedFields();
				$this->view->addVars([
					'page'        => $page,
					'pages'       => $pages,
					'stepCount'   => $stepCount,
					'pageName'    => $pageName,
					'stepPercent' => intval($page['step'] * 100 / $stepCount),
				]);
			}
			$this->view
				->setPageTitle($pageTitle)
				->setPageLayout($layout)
				->setPageName($pageName)
				->render();

		} catch (\Exception $ex) {
			$this->onError($ex);
		}
	}

	/**
	 * @param string $controller
	 * @param string $action
	 * @return boolean
	 */
	protected function handleAction($controller, $action) {
		if (empty($controller) || empty($action)) {
			return false;
		}
		switch ($controller) {
			case 'app':
				$this->handleAppController($action);
				break;
		}

		return true;
	}

	/**
	 *
	 * @param string $action
	 */
	protected function handleAppController($action) {
		switch ($action) {
			case 'lang':
				$this->actionAppLang();
				break;
		}
	}

	/**
	 * @return boolean
	 */
	protected function actionAppLang() {
		$lang = isset($_GET['value']) ? $_GET['value'] : '';
		setcookie('lang', $lang, time() + 24 * 3600, $this->getRelativeUrl());
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
	}

	/**
	 * @param \Exception $ex
	 */
	protected function onError($ex) {
		$this->view
			->setPageTitle('Ошибка установщика')
			->setPageLayout('error')
			->setPageName('error')
			->addVars([
				'errorMessage' => $ex->getMessage(),
			])
			->render();
	}

	/**
	 * @return array
	 */
	protected function getPages() {
		$pages = [
			'hello' => [
				'title' => App::t('Welcome'),
			],
			'requirements' => [
				'title' => App::t('Check of the system requirement'),
			],
			'yii' => [
				'title' => App::t('Framework path'),
			],
			'core' => [
				'title' => App::t('Select of the WoW core'),
			],
			'db' => [
				'title' => App::t('Database settings'),
			],
			'user' => [
				'title' => App::t('Select of the user'),
			],
			'struct' => [
				'title' => App::t('Creation of the tables'),
			],
			'privileges' => [
				'title' => App::t('Privileges'),
			],
			'config' => [
				'title' => App::t('Configuration writing'),
			],
			'finish' => [
				'title' => App::t('Finish'),
			],
		];

		$i = 1;
		foreach ($pages as $name => $item) {
			$pages[$name]['step'] = $i;
			++$i;
		}

		return $pages;
	}

	/**
	 * @return boolean
	 */
	public function isInstalled()
	{
		return !is_dir(__DIR__ . '/../../install');
	}

	/**
	 * @return boolean
	 */
	protected function writeDbConfig() {
		$result = false;
		$dbFilePath = __DIR__ . '/../../protected/config/db-local.php';

		$h = fopen($dbFilePath, 'w');
		if (!$h) {
			$this->view->addError('Не удалось записать в файл: ' . $dbFilePath);
			return false;
		}

		ob_start();
		echo
			"<?\n",
			"return [\n",
			"	'connectionString'=>'mysql:host=127.0.0.1;dbname={$this->view->getFieldValue('db_characters')}',\n",
			"	'emulatePrepare'=>true,\n",
			"	'username'=>'{$this->view->getFieldValue('db_transfer_user')}',\n",
			"	'password'=>'{$this->view->getFieldValue('db_transfer_password')}',\n",
			"	'charset'=>'utf8',\n",
			"	'enableParamLogging'=>true,\n",
			"];\n";
		$content = ob_get_clean();
		$writedSize = fwrite($h, $content);
		fclose($h);

		return $writedSize > 0;
	}

	/**
	 * @return boolean
	 */
	public function writeAppConfig()
	{
		$filePath = $this->getAppConfigAbsoluteFilePath();
		$localFilePath = $this->getAppConfigAbsoluteFilePath(true);
		$lines = file($filePath);
		if (!$lines) {
			$this->view->addError("Не удалось прочитать файл конфигурации приложения\n" . $filePath);
			return false;
		}

		$configContent = '';
		$params = [];
		foreach ($lines as $line) {
			// 'return [' -- begin
			// '];'       -- end

			$keyValue = explode('=>', $line);
			if (isset($keyValue[1])) {
				$key = trim($keyValue[0]);
				if ($key === "'core'") {
					$configContent .= "\t'core'=>'{$this->view->getFieldValue('core')}',\n";
					$params['core'] = true;
					continue;
				}
				elseif ($key === "'transferTable'") {
					$configContent .= "\t'transferTable'=>'{$this->view->getFieldValue('db_transfer_table')}',\n";
					$params['transferTable'] = true;
					continue;
				}
				elseif ($key === "'yiiDir'") {
					$configContent .= "\t'yiiDir'=>'{$this->view->getFieldValue('yii_dir')}',\n";
					$params['yiiDir'] = true;
					continue;
				}
			}

			if (trim($line) === '];') {
				if (!isset($params['core'])) {
					$configContent .= "\t'core'=>'{$this->view->getFieldValue('core')}',\n";
				}
				if (!isset($params['transferTable'])) {
					$configContent .= "\t'transferTable'=>'{$this->view->getFieldValue('db_transfer_table')}',\n";
				}
				if (!isset($params['yiiDir'])) {
					$configContent .= "\t'yiiDir'=>'{$this->view->getFieldValue('yii_dir')}',\n";
				}
			}

			$configContent .= $line;
		}

		$handle = fopen($localFilePath, 'w');
		if (!$handle) {
			$this->view->addError('Не удалось записать в файл: ' . $localFilePath);
			return false;
		}
		$writedSize = fwrite($handle, $configContent);
		fclose($handle);

		$this->writeDbConfig();
		$this->writeServiceConfig();
		$this->writeTransferOptionsConfig();

		return $writedSize > 0;
	}

	/**
	 * @return boolean
	 */
	protected function writeServiceConfig() {
		$serviceFilePath = __DIR__ . '/../../protected/config/service-local.php';
		$h = fopen($serviceFilePath, 'w');
		if (!$h) {
			$this->view->addError('Не удалось записать в файл: ' . $serviceFilePath);
			return false;
		}
		$writedSize = fwrite($h, "<?php return [];");
		fclose($h);

		return $writedSize > 0;
	}

	/**
	 * @return boolean
	 */
	protected function writeTransferOptionsConfig() {
		$serviceFilePath = __DIR__ . '/../../protected/config/toptions-local.php';
		$h = fopen($serviceFilePath, 'w');
		fwrite($h, "<?php return [];");
		fclose($h);

		return $h != false;
	}

	/**
	 * @param boolean
	 * @return string
	 */
	public function getAppConfigAbsoluteFilePath($local = false) {
		return __DIR__ . '/../..' . $this->getAppConfigRelativeFilePath($local);
	}

	/**
	 * @param boolean
	 * @return string
	 */
	public function getAppConfigRelativeFilePath($local = false) {
		$useLocal = $local ? '-local' : '';
		return $this->getAppConfigRelativeDir() . '/app' . $useLocal. '.php';
	}

	/**
	 * @return string
	 */
	public function getAppConfigRelativeDir() {
		return '/protected/config';
	}

	/**
	 * Recursive remove a directory
	 */
	private function _removeDir($dir)
	{
		$result = false;

		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != '.' && $object != '..') {
					$file = $dir . DIRECTORY_SEPARATOR . $object;
					if (is_dir($file)) {
						$result = $this->_removeDir($file);
					}
					else {
						$result = unlink($file);
					}
				}
			}
			$result = rmdir($dir) && $result;
		}

		return $result;
	}

	/**
	 * Remove a directory and all files
	 */
	public function removeDir()
	{
		$dir = realpath(__DIR__ . '/..');
		$result = $this->_removeDir($dir);
		if (!$result) {
			$this->view->addError('Не удалось удалить директорию ' . $dir);
		}
		return $result;
	}

	/**
	 * Load from file structure of database
	 *
	 * @return mixed SQL or false
	 */
	public function loadDbStructure()
	{
		$fileName = __DIR__ . '/../sql/chd_structure.sql';

		if (!file_exists($fileName)) {
			$this->view->addError('Файл ' . $fileName . ' не найден');
			return false;
		}

		$sql = file_get_contents($fileName);
		if (!$sql) {
			$fileName->addError($fileName . ' не найден или пуст');
		}

		return $sql;
	}

	/**
	 * Load privileges script, using 'db_wowtransfer_user' field
	 *
	 * @return mixed SQL or false
	 */
	public function loadDbPrivileges()
	{
		// TODO: make function (filePrefix)

		$core = $this->view->getFieldValue('core');
		if (empty($core)) {
			$this->view->addError(App::t('Core of the WoW server not found'));
			return false;
		}

		$fileName = 'sql/chd_privileges_' . $core . '.sql';
		if (!file_exists($fileName)) {
			$this->view->addError('Файл ' . $fileName . ' не найден');
			return false;
		}

		$sql = file_get_contents($fileName);
		if (empty($sql)) {
			$this->view->addError('Файл ' . $fileName . ' пустой');
			return false;
		}

		$userName      = $this->view->getFieldValue('db_transfer_user');
		$userHost      = $this->view->getFieldValue('db_transfer_user_host');
		$transferTable = $this->view->getFieldValue('db_transfer_table');
		$authDb        = $this->view->getFieldValue('db_auth');
		$charactersDb  = $this->view->getFieldValue('db_characters');

		// TODO: checking...

		$sql = str_replace('%username%', $userName, $sql);
		$sql = str_replace('%host%', $userHost, $sql);
		$sql = str_replace('%transfer_table%', $transferTable, $sql);
		$sql = str_replace('%db_auth%', $authDb, $sql);
		$sql = str_replace('%db_characters%', $charactersDb, $sql);

		return $sql;
	}

	/**
	 * @return type
	 */
	public function getRelativeUrl() {
		return '/chdphp';
	}

	/**
	 * @param string $message
	 * @return string
	 */
	public static function t($message) {
		if (isset(self::$messages[$message])) {
			return self::$messages[$message];
		}
		return $message;
	}

	/**
	 * @return string
	 */
	public function getLanguage() {
		return $this->language;
	}
}
