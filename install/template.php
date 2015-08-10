<?php

class InstallerTemplate
{
	private $_name = 'Wowtransfer клиент';
	private $_errors = array();
	private $_checkItems = array();
	private $_hiddenFields = array();

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
		foreach ($_SESSION as $name => $value)
		{
			if (!isset($_POST[$name]))
				$_POST[$name] = $value;	
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
		$_SESSION = isset($_POST) ? $_POST : array();
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
		if (empty($this->_errors))
			return;

		echo '<div class="alert alert-danger">';
		echo '<p>Необходимо исправить следующие ошибки:</p>';
		echo '<ul>';
		foreach ($this->_errors as $error)
			echo '<li>' . $error . '</li>';
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
	 *
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
			<?php foreach ($this->_checkItems as $name => $item): ?>
			<tr>
				<td><?php echo $item['value']; ?></td>
				<td>
<?php
					$resultClass = 'warning';
					$resultTitle = 'Предупреждение';
					if (!empty($item['result']))
					{
						$resultClass = 'success';
						$resultTitle = 'OK';
					}
?>
					<span class="label label-<?php echo $resultClass; ?>"><?php echo $resultTitle; ?></span>
				</td>
				<td><?php echo isset($item['comment']) ? $item['comment'] : ''; ?></td>
			</tr>
			<?php endforeach; ?>
			
		</tbody>
		</table>
<?php
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
		$_hiddenFields[$name] = $value;
	}

	/**
	 * @param array $excludeHiddenFields Like ['key' => 'value', ...]
	 */
	public function printHiddenFields($excludeHiddenFields = null)
	{
		if (!empty($excludeHiddenFields))
		{
			foreach ($this->_hiddenFields as $name => $value)
			{
				if (!in_array($name, $excludeHiddenFields))
					echo '<input type="hidden" name="' . $name . '" value="' . $value. '">';
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

		if (!file_exists($fileName))
		{
			$this->addError('Файл ' . $fileName . ' не найден');
			return false;
		}

		$sql = file_get_contents($fileName);

		if (!$sql)
			$fileName->addError($fileName . ' не найден или пуст');

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
		if (empty($core))
		{
			$this->addError('Ядро WoW сервера не найдено');
			return false;
		}

		$fileName = 'sql/chd_procedures_' . $core . '.sql';
		if (!file_exists($fileName))
		{
			$this->addError('Файл ' . $fileName . ' не найден');
			return false;
		}

		$sql = file_get_contents($fileName);
		if (empty($sql))
		{
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
		if (empty($core))
		{
			$this->addError('Ядро WoW сервера не найдено');
			return false;
		}

		$fileName = 'sql/chd_privileges_' . $core . '.sql';
		if (!file_exists($fileName))
		{
			$this->addError('Файл ' . $fileName . ' не найден');
			return false;
		}

		$sql = file_get_contents($fileName);
		if (empty($sql))
		{
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

		if (is_dir($dir))
		{
			$objects = scandir($dir);
			foreach ($objects as $object)
			{
				if ($object != '.' && $object != '..')
				{
					$file = $dir . DIRECTORY_SEPARATOR . $object;
					if (is_dir($file))
						$result = $this->_removeDir($file) && $result;
					else
						$result = unlink($file) && $result;
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
		return $this->_removeDir(__DIR__);
	}

	/**
	 * @return string
	 */
	private function getInstalledFilePath()
	{
		return __DIR__ . '/../.installed';
	}

	/**
	 * @return boolean
	 */
	public function saveInstallStatus()
	{
		$filePath = $this->getInstalledFilePath();
		if (file_exists($filePath)) {
			return true;
		}

		$handle = fopen($filePath, 'w');
		if ($handle) {
			fclose($handle);
		}

		return $handle !== false;
	}

	/**
	 * @return boolean
	 */
	public function isInstalled()
	{
		$filePath = $this->getInstalledFilePath();
		return file_exists($filePath);
	}

	/**
	 * @return boolean
	 */
	public function writeAppConfig()
	{
		$filePath = $this->getAppConfigAbsoluteFilePath();
		$lines = file($filePath);
		if (!$lines)
		{
			$this->addError("Не удалось прочитать файл конфигурации приложения\n" . $filePath);
			return false;
		}

		$configContent = '';
		$params = array(
			'core' => false,
			'transferTable' => false,
		);
		foreach ($lines as $line)
		{
			// 'return array(' -- begin
			// ');'            -- end

			$keyValue = explode('=>', $line);
			if (isset($keyValue[1]))
			{
				$key = trim($keyValue[0]);
				if ($key === "'core'")
				{
					$configContent .= "\t'core'=>'{$this->getFieldValue('core')}',\n";
					$params['core'] = true;
					continue;
				}
				elseif ($key === "'transferTable'")
				{
					$configContent .= "\t'transferTable'=>'{$this->getFieldValue('db_transfer_table')}',\n";
					$params['transferTable'] = true;
					continue;
				}
			}

			if ($line === ');')
			{
				if (!$params['core'])
					$configContent .= "\t'core'=>'{$this->getFieldValue('core')}',\n";
				if (!$params['transferTable'])
					$configContent .= "\t'transferTable'=>'{$this->getFieldValue('db_transfer_table')}',\n";
			}

			$configContent .= $line;
		}

		$handle = fopen($filePath, 'w');
		if ($handle)
		{
			fwrite($handle, $configContent);
			fclose($handle);
		}

		$this->writeDbConfig();

		return $handle !== false;
	}

	protected function writeDbConfig() {
		$dbFilePath = __DIR__ . '/../protected/config/db-local.php';

		$h = fopen($dbFilePath, 'w');
		if ($h) {
			ob_start();
			echo
				"<?php\n",
				"return [\n",
				"	'connectionString'=>'mysql:host=127.0.0.1;dbname={$this->getFieldValue('db_characters')}',\n",
				"	'emulatePrepare'=>true,\n",
				"	'username'=>'{$this->getFieldValue('db_transfer_user')}',\n",
				"	'password'=>'{$this->getFieldValue('db_transfer_password')}',\n",
				"	'charset'=>'utf8',\n",
				"	'enableParamLogging'=>true,\n",
				"];\n";
			$content = ob_get_clean();
			fwrite($h, $content);
			fclose($h);
		}

		return true;
	}

	/**
	 * @return string
	 */
	public function getAppConfigAbsoluteFilePath() {
		return __DIR__ . '/..' . $this->getAppConfigRelativeFilePath();
	}

	/**
	 * @return string
	 */
	public function getAppConfigRelativeFilePath() {
		return '/protected/config/app.php';
	}
}