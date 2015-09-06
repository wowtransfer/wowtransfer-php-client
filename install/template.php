<?

class InstallerTemplate
{
	/**
	 * @var array
	 */
	private $_errors = [];
	/**
	 * @var array
	 */
	private $_checkItems = [];
	/**
	 * @var array
	 */
	private $_hiddenFields = [];

	/**
	 * @return string Field's value by $name
	 */
	public function getFieldValue($name)
	{
		return isset($this->_hiddenFields[$name]) ? $this->_hiddenFields[$name] : '';
	}

	/**
	 * Call before render of context
	 */
	public function readSubmitedFields()
	{
		session_start();
		foreach ($_SESSION as $name => $value) {
			if (!isset($_POST[$name])) {
				$_POST[$name] = $value;
			}
		}
		session_write_close();

		$this->_hiddenFields = $_POST;
	}

	/**
	 * Call before redirect
	 */
	public function writeSubmitedFields()
	{
		session_start();
		$_SESSION = isset($_POST) ? $_POST : [];
		session_write_close();
	}

	/**
	 * Call on first installer page
	 */
	public function clearSubmitedFields()
	{
		session_start();
		session_unset();
		session_write_close();
	}

	/**
	 * @param string $error
	 */
	public function addError($error)
	{
		$this->_errors[] = $error;
	}

	/**
	 * @return boolean
	 */
	public function hasErrors()
	{
		return !empty($this->_errors);
	}

	/**
	 * Display errors
	 */
	public function errorSummary()
	{
		if (empty($this->_errors)) {
			return;
		}

		echo '<div class="alert alert-danger">';
		echo '<p>Необходимо исправить следующие ошибки:</p>';
		echo '<ul>';
		foreach ($this->_errors as $error) {
			echo '<li>' . $error . '</li>';
		}
		echo '</ul>';
		echo '</div>';
	}

	/**
	 * Add item to checktable
	 */
	public function addCheckItem($name, $item)
	{
		$this->_checkItems[$name] = $item;
	}

	/**
	 * @return null
	 */
	public function printCheckTable()
	{
?>
		<table class="table">
		<thead>
			<tr>
				<th>Значение</th>
				<th>Результат</th>
				<th>Комментарий</th>
			</tr>
		</thead>
		<tbody>
			<? foreach ($this->_checkItems as $name => $item): ?>
			<tr>
				<td><?= $item['value']; ?></td>
				<td>
<?
					$resultClass = 'warning';
					$resultTitle = 'Предупреждение';
					if (!empty($item['result'])) {
						$resultClass = 'success';
						$resultTitle = 'OK';
					}
?>
					<span class="label label-<?= $resultClass; ?>"><?= $resultTitle; ?></span>
				</td>
				<td><?= isset($item['comment']) ? $item['comment'] : ''; ?></td>
			</tr>
			<? endforeach ?>
			
		</tbody>
		</table>
<?
	}

	/**
	 * @param array $fields Array like ['key' => 'value']
	 */
	public function setHiddenFields($fields)
	{
		$this->_hiddenFields = $fields;
	}

	/**
	 * @param string $name
	 * @param string $value
	 */
	public function addHiddenField($name, $value)
	{
		$this->_hiddenFields[$name] = $value;
	}

	/**
	 * @param array $excludeHiddenFields Like ['key' => 'value', ...]
	 */
	public function printHiddenFields($excludeHiddenFields = null)
	{
		if (!empty($excludeHiddenFields)) {
			foreach ($this->_hiddenFields as $name => $value) {
				if (!in_array($name, $excludeHiddenFields)) {
					echo '<input type="hidden" name="' . $name . '" value="' . $value. '">';
				}
			}
		}
	}

	/**
	 * Load from file structure of database
	 *
	 * @return mixed SQL or false
	 */
	public function loadDbStructure()
	{
		$fileName = 'sql/chd_structure.sql';

		if (!file_exists($fileName)) {
			$this->addError('Файл ' . $fileName . ' не найден');
			return false;
		}

		$sql = file_get_contents($fileName);
		if (!$sql) {
			$fileName->addError($fileName . ' не найден или пуст');
		}

		return $sql;
	}

	/**
	 * Load database procedures
	 *
	 * @return mixed SQL of false
	 */
	public function loadDbProcedures()
	{
		// TODO: make function (filePrefix)

		$core = $this->getFieldValue('core');
		if (empty($core)) {
			$this->addError('Ядро WoW сервера не найдено');
			return false;
		}

		$fileName = 'sql/chd_procedures_' . $core . '.sql';
		if (!file_exists($fileName)) {
			$this->addError('Файл ' . $fileName . ' не найден');
			return false;
		}

		$sql = file_get_contents($fileName);
		if (empty($sql)) {
			$this->addError('Файл ' . $fileName . ' пустой');
			return false;
		}
		/*
		$dbWowtransferUser = $this->getFieldValue('db_wotransfer_user');
		if (empty($dbWowtransferUser))
		{
			$this->addError('Пользователь, под которым должно работать приложение, не определен');
			return false;
		}
		str_replace('%username%', $dbWowtransferUser, $sql);
		*/

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

		$core = $this->getFieldValue('core');
		if (empty($core)) {
			$this->addError('Ядро WoW сервера не найдено');
			return false;
		}

		$fileName = 'sql/chd_privileges_' . $core . '.sql';
		if (!file_exists($fileName)) {
			$this->addError('Файл ' . $fileName . ' не найден');
			return false;
		}

		$sql = file_get_contents($fileName);
		if (empty($sql)) {
			$this->addError('Файл ' . $fileName . ' пустой');
			return false;
		}

		$userName      = $this->getFieldValue('db_transfer_user');
		$userHost      = $this->getFieldValue('db_transfer_user_host');
		$transferTable = $this->getFieldValue('db_transfer_table');
		$authDb        = $this->getFieldValue('db_auth');
		$charactersDb  = $this->getFieldValue('db_characters');

		// TODO: checking...

		$sql = str_replace('%username%', $userName, $sql);
		$sql = str_replace('%host%', $userHost, $sql);
		$sql = str_replace('%transfer_table%', $transferTable, $sql);
		$sql = str_replace('%db_auth%', $authDb, $sql);
		$sql = str_replace('%db_characters%', $charactersDb, $sql);

		return $sql;
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
		$result = $this->_removeDir(__DIR__);
		if (!$result) {
			$this->addError('Не удалось удалить директорию ' . __DIR__);
		}
		return $result;
	}

	/**
	 * @return boolean
	 */
	public function isInstalled()
	{
		return !is_dir(__DIR__ . '/../install');
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
			$this->addError("Не удалось прочитать файл конфигурации приложения\n" . $filePath);
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
					$configContent .= "\t'core'=>'{$this->getFieldValue('core')}',\n";
					$params['core'] = true;
					continue;
				}
				elseif ($key === "'transferTable'") {
					$configContent .= "\t'transferTable'=>'{$this->getFieldValue('db_transfer_table')}',\n";
					$params['transferTable'] = true;
					continue;
				}
				elseif ($key === "'yiiDir'") {
					$configContent .= "\t'yiiDir'=>'{$this->getFieldValue('yii_dir')}',\n";
					$params['yiiDir'] = true;
					continue;
				}
			}

			if (trim($line) === '];') {
				if (!isset($params['core'])) {
					$configContent .= "\t'core'=>'{$this->getFieldValue('core')}',\n";
				}
				if (!isset($params['transferTable'])) {
					$configContent .= "\t'transferTable'=>'{$this->getFieldValue('db_transfer_table')}',\n";
				}
				if (!isset($params['yiiDir'])) {
					$configContent .= "\t'yiiDir'=>'{$this->getFieldValue('yii_dir')}',\n";
				}
			}

			$configContent .= $line;
		}

		$handle = fopen($localFilePath, 'w');
		if (!$handle) {
			$this->addError("Не удалось записать в файл $localFilePath\n");
			return false;
		}
		fwrite($handle, $configContent);
		fclose($handle);

		$this->writeDbConfig();
		$this->writeServiceConfig();
		$this->writeTransferOptionsConfig();

		return true;
	}

	/**
	 * @return boolean
	 */
	protected function writeDbConfig() {
		$result = false;
		$dbFilePath = __DIR__ . '/../protected/config/db-local.php';

		$h = fopen($dbFilePath, 'w');
		if ($h) {
			ob_start();
			echo
				"<?\n",
				"return [\n",
				"	'connectionString'=>'mysql:host=127.0.0.1;dbname={$this->getFieldValue('db_characters')}',\n",
				"	'emulatePrepare'=>true,\n",
				"	'username'=>'{$this->getFieldValue('db_transfer_user')}',\n",
				"	'password'=>'{$this->getFieldValue('db_transfer_password')}',\n",
				"	'charset'=>'utf8',\n",
				"	'enableParamLogging'=>true,\n",
				"];\n";
			$content = ob_get_clean();
			$writedSize = fwrite($h, $content);
			fclose($h);

			$result = $writedSize > 0;
		}

		return $result;
	}

	/**
	 * @return boolean
	 */
	protected function writeServiceConfig() {
		$serviceFilePath = __DIR__ . '/../protected/config/service-local.php';
		$h = fopen($serviceFilePath, 'w');
		fwrite($h, "<?php return [];");
		fclose($h);

		return $h != false;
	}

	/**
	 * @return boolean
	 */
	protected function writeTransferOptionsConfig() {
		$serviceFilePath = __DIR__ . '/../protected/config/toptions-local.php';
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
		return __DIR__ . '/..' . $this->getAppConfigRelativeFilePath($local);
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
}
