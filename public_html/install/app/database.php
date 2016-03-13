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
        $settings = App::$app->getSettings();
		$host     = $settings->getFieldValue('db_host');
		$port     = $settings->getFieldValue('db_port');
		$user     = $settings->getFieldValue('db_user');
		$password = $settings->getFieldValue('db_password');

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
        $settings = App::$app->getSettings();
		try
		{
			$errorPrefix = 'Проверка подключения: ';
			$pdo = $this->_connect('information_schema');

			// check auth database
			$errorPrefix = 'Проверка базы данных с аккаунтами: ';
			$pdo->query('USE `' . $settings->getFieldValue('db_auth') . '`');

			// check characters database
			$errorPrefix = 'Проверка базы данных с персонажами: ';
			$pdo->query('USE `' . $settings->getFieldValue('db_characters') . '`');

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
        $settings = App::$app->getSettings();
		$db = $settings->getFieldValue('db_characters');
		$dbTransferTableName = $settings->getFieldValue('db_transfer_table');

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
	public function applyPrivileges()
	{
        $settings = App::$app->getSettings();
		$db = $settings->getFieldValue('db_characters');

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