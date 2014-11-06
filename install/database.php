<?php

class InstallerDatabaseManager
{
	private $_template;

	public function InstallerDatabaseManager($template)
	{
		$this->_template = $template;
	}

	/**
	 * @return bool
	 */
	public function checkConnection()
	{
		$host     = $this->_template->getFieldValue('db_host');
		$port     = $this->_template->getFieldValue('db_port');
		$user     = $this->_template->getFieldValue('db_user');
		$password = $this->_template->getFieldValue('db_password');

		$dsn = 'mysql:host=' . $host . ';dbname=information_schema'; // . ';charset=utf8";

		$options = array(
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);

		try
		{
			$errorPrefix = 'Проверка подключения: ';
			$pdo = new PDO($dsn, $user, $password, $options);

			// check auth database
			$errorPrefix = 'Проверка базы данных с аккаунтами: ';
			$pdo->query('USE ' . $this->_template->getFieldValue('db_auth'));

			// check characters database
			$errorPrefix = 'Проверка базы данных с персонажами: ';
			$pdo->query('USE ' . $this->_template->getFieldValue('db_characters'));

			unset($pdo);
		}
		catch (PDOException $ex)
		{
			$this->_template->addError($errorPrefix . $ex->getMessage());
			return false;
		}

		return true;
	}

	public function createUser()
	{
		
	}

	public function createProcedures()
	{
		
	}

	public function createStructure()
	{
		
	}
}