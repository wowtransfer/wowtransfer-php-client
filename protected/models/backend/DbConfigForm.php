<?php

class DbConfigForm extends PhpFileForm
{
	/**
	 * @var string
	 */
	public $host;

	/**
	 * @var string
	 */
	public $dbName;

	/**
	 * @var string
	 */
	public $username;

	/**
	 * @var string
	 */
	public $password;

	/**
	 * @var string
	 */
	public $password2;

	/**
	 * @var string
	 */
	public $charset;

	/**
	 * @var string
	 */
	public $connectionString;

	/**
	 * @return array
	 */
	public function rules()
	{
		return [
			['host, dbName, username, password', 'required'],
			['charset', 'default', 'value' => 'utf8'],
			['password2', 'safe'],
			['password', 'compare', 'compareAttribute' => 'password2', 'operator' => '='],
			['host, dbName, username, password, password2, charset', 'filter', 'filter' => 'trim'],
		];
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		return [
			'host' => Yii::t('app', 'Host'),
			'dbName' => Yii::t('app', 'Database name'),
			'username' => Yii::t('app', 'User'),
			'password' => Yii::t('app', 'Password'),
			'password2' => Yii::t('app', 'Password confirmation'),
			'charset' => Yii::t('app', 'Charset'),
		];
	}

	/**
	 * @return string
	 */
	protected function getConfigFilePath()
	{
		$filePath = 'config' . DIRECTORY_SEPARATOR . 'db-local.php';
		return Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . $filePath;
	}

	/**
	 * @return string
	 */
	protected function getDefaultConfigFilePath() {
		$filePath = 'config' . DIRECTORY_SEPARATOR . 'db.php';
		return Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . $filePath;
	}

	public function save($validate = true) {
		if ($validate && !$this->validate()) {
			return false;
		}

		$filePath = $this->getConfigFilePath();
		if (!file_exists($filePath)) {
			throw new CHttpException(404, 'File not found: ' . $filePath);
		}

		$attributes = [
			'connectionString', 'username', 'password', 'charset',
		];
		$this->connectionString = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName;
		$this->setFilePath($filePath);
		$this->setWorkAttributes($attributes);
		$result = parent::save();
		if ($result) {
			$message = Yii::t('app', 'Configuration of databse was changed success.');
			Yii::app()->user->setFlash('success', $message);
		}
		return $result;	}

	public function load() {
		$filePathDefault = $this->getDefaultConfigFilePath();
		$config = require $filePathDefault;
		$filePath = $this->getConfigFilePath();
		if (file_exists($filePath)) {
			$config = array_merge($config, require $filePath);
		}

		// mysql:host=127.0.0.1;dbname=characters
		$params = $this->getConnectionStringArr($config['connectionString']);

		$this->dbName = isset($params['dbname']) ? $params['dbname'] : '';
		$this->charset = $config['charset'];
		$this->host = isset($params['host']) ? $params['host'] : '';
		$this->username = $config['username'];
		$this->password = ''; //$config['password'];
		$this->password2 = '';
	}

	/**
	 * @param array
	 */
	private function getConnectionStringArr($connectionString) {
		$paramsStr = $connectionString;
		$pos = strpos($connectionString, ':');
		if ($pos) {
			$paramsStr = substr($connectionString, $pos + 1); // exclude 'mysql:'
		}
		$params = [];
		$paramsArr = explode(';', $paramsStr);
		foreach ($paramsArr as $param) {
			list($name, $value) = explode('=', $param);
			$params[$name] = $value;
		}
		return $params;
	}
}

