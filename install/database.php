<?php

class InstallerDatabaseManager
{
	private $_template;

	public function InstallerDatabaseManager($template)
	{
		$this->_template = $template;
	}

	/**
	 * Connect to database
	 *
	 * @param $database string
	 *
	 * @throw PDOException
	 *
	 * @return PDO
	 */
	private function _connect($database)
	{
		$host     = $this->_template->getFieldValue('db_host');
		$port     = $this->_template->getFieldValue('db_port');
		$user     = $this->_template->getFieldValue('db_user');
		$password = $this->_template->getFieldValue('db_password');

		if (empty($host))
			$host = 'localhost';
		if (empty($port))
			$port = 3306;

		$dsn = 'mysql:host=' . $host . ';dbname=' . $database; // . ';charset=utf8";

		$options = array(
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);

		return new PDO($dsn, $user, $password, $options);
	}

	/**
	 * @return bool
	 */
	public function checkConnection()
	{
		try
		{
			$errorPrefix = 'Проверка подключения: ';
			$pdo = $this->_connect('information_schema');

			// check auth database
			$errorPrefix = 'Проверка базы данных с аккаунтами: ';
			$pdo->query('USE `' . $this->_template->getFieldValue('db_auth') . '`');

			// check characters database
			$errorPrefix = 'Проверка базы данных с персонажами: ';
			$pdo->query('USE `' . $this->_template->getFieldValue('db_characters') . '`');

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
		return true;
	}

	/**
	 *
	 */
	public function createStructure()
	{
		$db = $this->_template->getFieldValue('db_characters');
		$dbTransferTableName = $this->_template->getFieldValue('db_transfer_table');

		try
		{
			$pdo = $this->_connect($db);

			// SQL only with simple queries, separated by ';'
			$sql = $this->_template->loadDbStructure();
			$queries = explode(';', $sql);
			foreach ($queries as $query)
			{
				$query = trim($query);
				// $query = removeComment($query);
				if (!empty($query))
					$pdo->exec($query);
			}
		}
		catch (PDOException $ex)
		{
			$this->_template->addError('Выполнение запроса: ' . $ex->getMessage());
			return false;
		}

		return true;
	}

	/**
	 *
	 */
	public function createProcedures()
	{
		$db = $this->_template->getFieldValue('db_characters');

		try
		{
			$pdo = $this->_connect($db);

			$sql = $this->_template->loadDbProcedures();
			if (!$sql)
				return false;

			// first line always start with 'DELIMITER $$'
			$queries = explode('$$', $sql);
			if (substr(trim($queries[0]), 0, 9) === 'DELIMITER')
				array_shift($queries);

			foreach ($queries as $query)
			{
				$query = trim($query);
				// $query = removeComment($query);
				if (!empty($query))
					$pdo->exec($query);
			}
		}
		catch (PDOException $ex)
		{
			$this->_template->addError('Выполнение запроса: ' . $ex->getMessage());
			return false;
		}

		return true;
	}

	/**
	 *
	 */
	public function applyPrivileges()
	{
		$db = $this->_template->getFieldValue('db_characters');

		try
		{
			$pdo = $this->_connect($db);

			$sql = $this->_template->loadDbPrivileges();
			if (!$sql)
				return false;

			$queries = explode(';', $sql);
			foreach ($queries as $query)
			{
				$query = trim($query);
				// $query = removeComment($query);
				if (!empty($query))
					$pdo->exec($query);
			}
		}
		catch (PDOException $ex)
		{
			$this->_template->addError('Выполнение запроса: ' . $ex->getMessage());
			return false;
		}

		return true;
	}
}