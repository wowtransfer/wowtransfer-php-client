<?php

class AppConfigForm extends PhpFileForm
{
	/* virtual attributes */

	/**
	 * @var string
	 */
	public $adminsStr = '';

	/**
	 * @var string
	 */
	public $modersStr = '';

	/* attributes */

	/**
	 * @var array
	 */
	public $admins;

	/**
	 * @var array
	 */
	public $moders;

	/**
	 * @var string
	 */
	public $siteUrl;

	/**
	 * @var string
	 */
	public $core;

	/**
	 * @var string
	 */
	public $emailAdmin;

	/**
	 * @var integer
	 */
	public $maxTransfersCount;

	/**
	 * @var integer 
	 */
	public $maxAccountCharsCount;

	/**
	 * @var string
	 */
	public $transferTable;

	/**
	 * @var boolean
	 */
	public $yiiDebug;

	/**
	 * @var integer
	 */
	public $yiiTraceLevel;

	/**
	 * @var boolean
	 */
	public $onlyCheckedServers;

	public function __construct($scenario = '') {
		parent::__construct($scenario);
		$this->loadDefaults();
	}

	public function rules()
	{
		return [
			['core, siteUrl, transferTable', 'required'],
			['core', 'match', 'pattern' => '/^[a-z0-9_]+$/', 'allowEmpty' => false],
			['maxTransfersCount, maxAccountCharsCount', 'numerical', 'integerOnly' => true, 'min' => 0, 'max' => 1000],
			['emailAdmin', 'email', 'allowEmpty' => false],
			['transferTable', 'match', 'pattern' => '/^[a-z0-9_]+$/', 'allowEmpty' => false],
			['adminsStr', 'required'], // adminsStr and modersStr have a pattern '\w, \w, \w, \w'
			['admins, moders, modersStr', 'safe'],
			['yiiDebug, onlyCheckedServers', 'boolean'],
			['yiiTraceLevel', 'numerical', 'integerOnly' => true, 'min' => 0, 'max' => 5],
		];
	}

	public function attributeLabels()
	{
		return [
			'siteUrl'              => Yii::t('app', 'Url of a site'),
			'emailAdmin'           => Yii::t('app', 'Email of administrator'),
			'core'                 => Yii::t('app', 'Core of WoW server'),
			'maxTransfersCount'    => Yii::t('app', 'Max request count on the account'),
			'maxAccountCharsCount' => Yii::t('app', 'Max characters count on the account'),
			'adminsStr'            => Yii::t('app', 'Administrators'),
			'modersStr'            => Yii::t('app', 'Moderators'),
			'transferTable'        => Yii::t('app', 'Requests table'),
			'yiiDebug'             => Yii::t('app', 'Debug mode'),
			'onlyCheckedServers'   => Yii::t('app', 'Only checked servers'),
			'yiiTraceLevel'        => 'YII_TRACE_LEVEL',
		];
	}

	/**
	 * @return string
	 */
	protected function getConfigFilePath()
	{
		return Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . 'config/app-local.php';
	}

	/**
	 * @return string
	 */
	protected function getDefaultConfigFilePath() {
		return Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . 'config/app.php';
	}

	/**
	 * @return boolean
	 */
	protected function beforeValidate() {
		settype($this->yiiDebug, 'boolean');
		settype($this->onlyCheckedServers, 'boolean');
		settype($this->yiiTraceLevel, 'int');
		settype($this->maxAccountCharsCount, 'int');
		settype($this->maxTransfersCount, 'int');
		return parent::beforeValidate();
	}

	/**
	 * @param boolean $validate
	 * @throws CHttpException
	 */
	public function save($validate = true) {
		if ($validate && !$this->validate()) {
			return false;
		}
		$filePath = $this->getConfigFilePath();
		if (!file_exists($filePath)) {
			throw new CHttpException(404, 'File not found: ' . $filePath);
		}

		$attributes = [
			'siteUrl', 'emailAdmin', 'core', 'maxTransfersCount',
			'maxAccountCharsCount', 'admins', 'moders', 'transferTable',
			'yiiDebug', 'yiiTraceLevel', 'onlyCheckedServers',
		];
		$this->setFilePath($filePath);
		$this->setWorkAttributes($attributes);
		$result = parent::save();
		if ($result) {
			$message = Yii::t('app', 'Configuration of application was changed success.');
			Yii::app()->user->setFlash('success', $message);
		}
		return $result;
	}

	/**
	 * @return boolean
	 * @throws CHttpException
	 * @todo Make abstract function
	 */
	public function load() {
		$filePath = $this->getConfigFilePath();
		if (file_exists($filePath)) {
			$config = require $filePath;
		}
		else {
			$filePath = $this->getDefaultConfigFilePath();
			$config = require $filePath;
		}

		if (!is_array($config)) {
			throw new CHttpException(404, 'File ' . $filePath . ' returns not an array');
		}
		$result = parent::loadFromArray($config);
		$this->adminsStr = implode(',', $this->admins);
		$this->modersStr = implode(',', $this->moders);

		return $result;
	}

	/**
	 * @return boolean
	 */
	public function loadDefaults() {
		$filePath = $this->getDefaultConfigFilePath();
		return $this->loadFromArray(require $filePath);
	}

	/**
	 * @param string $str
	 * @return array
	 */
	protected function trimedStrToArray($str) {
		$result = [];
		$arr = explode(',', $str);
		if (is_array($arr)) {
			foreach ($arr as $name) {
				$name = trim($name);
				if ($name) {
					$result[] = $name;
				}
			}
		}
		return $result;
	}

	/**
	 * @return \AppConfigForm
	 */
	public function adminsFromUser() {
		$this->admins = $this->trimedStrToArray($this->adminsStr);
		return $this;
	}

	/**
	 * @return \AppConfigForm
	 */
	public function modersFromUser() {
		$this->moders = $this->trimedStrToArray($this->modersStr);
		return $this;
	}
}