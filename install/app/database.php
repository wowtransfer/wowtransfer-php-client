<?php
namespace Installer;

use \Installer\App;

class DatabaseManager
{
	protected $view;

	public function __construct($view)
	{
		$this->view = $view;
	}

	/**
	 * Connect to database
	 *
	 * @param $database string
	 *
	 * @throw \PDOException
	 *
	 * @return \PDO
	 */
	private function _connect($database = '')
	{
		$host     = $this->view->getFieldValue('db_host');
		$port     = $this->view->getFieldValue('db_port');
		$user     = $this->view->getFieldValue('db_user');
		$password = $this->view->getFieldValue('db_password');

		if (empty($host)) {
			$host = 'localhost';
		}
		if (empty($port)) {
			$port = 3306;
		}

		$dsn = 'mysql:host=' . $host . ';dbname=' . $database; // . ';charset=utf8";

		$options = array(
			\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
		);

		return new \PDO($dsn, $user, $password, $options);
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
			$pdo->query('USE `' . $this->view->getFieldValue('db_auth') . '`');

			// check characters database
			$errorPrefix = 'Проверка базы данных с персонажами: ';
			$pdo->query('USE `' . $this->view->getFieldValue('db_characters') . '`');

			unset($pdo);
		}
		catch (PDOException $ex)
		{
			$this->view->addError($errorPrefix . $ex->getMessage());
			return false;
		}

		return true;
	}

	/**
	 * @param string $user
	 * @param string $password
	 * @param string $host
	 *
	 * @return bool
	 */
	public function createUser($user, $password, $host)
	{
		if (empty($host)) {
			$host = 'localhost';
		}

		try {
			$pdo = $this->_connect();

			// check if user exists alredy
			/*$query = "
				SELECT
					count(*) AS count
				FROM
					mysql.user
				WHERE
					User = '$user'";
			$userExists = $pdo->query($query)->fetchColumn() > 0;
			if ($userExists) {
				throw new Exception('Пользователь существует');
			}*/

			$query = "CREATE USER '$user'@'$host' IDENTIFIED BY '$password'";
			$pdo->exec($query);

			unset($pdo);
		}
		catch (\PDOException $ex)
		{
			$this->view->addError('Выполнение запроса: ' . $ex->getMessage());
			return false;
		}

		return true;
	}

	/**
	 *
	 */
	public function createStructure()
	{
		$db = $this->view->getFieldValue('db_characters');
		$dbTransferTableName = $this->view->getFieldValue('db_transfer_table');

		try
		{
			$pdo = $this->_connect($db);

			// SQL only with simple queries, separated by ';'
			$sql = App::$app->loadDbStructure();
			$queries = explode(';', $sql);
			foreach ($queries as $query)
			{
				$query = trim($query);
				// $query = removeComment($query);
				if (!empty($query))
					$pdo->exec($query);
			}

			unset($pdo);
		}
		catch (\PDOException $ex)
		{
			$this->view->addError('Выполнение запроса: ' . $ex->getMessage());
			return false;
		}

		return true;
	}

	/**
	 *
	 */
	public function createProcedures()
	{
		$db = $this->view->getFieldValue('db_characters');

		try {
			$pdo = $this->_connect($db);

			$sql = App::$app->loadDbProcedures();
			if (!$sql) {
				return false;
			}

			// first line always start with 'DELIMITER $$'
			$queries = explode('$$', $sql);
			if (substr(trim($queries[0]), 0, 9) === 'DELIMITER') {
				array_shift($queries);
			}

			foreach ($queries as $query) {
				$query = trim($query);
				// $query = removeComment($query);
				if (!empty($query)) {
					$pdo->exec($query);
				}
			}

			unset($pdo);
		}
		catch (\PDOException $ex) {
			$this->view->addError('Выполнение запроса: ' . $ex->getMessage());
			return false;
		}

		return true;
	}

	/**
	 *
	 */
	public function applyPrivileges()
	{
		$db = $this->view->getFieldValue('db_characters');

		try {
			$pdo = $this->_connect($db);

			$sql = App::$app->loadDbPrivileges();
			if (!$sql) {
				return false;
			}

			$queries = explode(';', $sql);
			foreach ($queries as $query) {
				$query = trim($query);
				// $query = removeComment($query);
				if (!empty($query)) {
					$pdo->exec($query);
				}
			}

			unset($pdo);
		}
		catch (\PDOException $ex) {
			$this->view->addError('Выполнение запроса: ' . $ex->getMessage());
			return false;
		}

		return true;
	}
}