<?php

class ServiceConfigForm extends PhpFileForm {

	/**
	 * @var string API Base url, without / on end
	 */
	protected $serviceBaseUrl;

	/**
	 * @var string
	 */
	public $apiBaseUrl;

	/**
	 *
	 * @var string
	 */
	public  $serviceUsername;

	/**
	 * @var string
	 */
	public  $accessToken;

	/**
	 *
	 * @var string
	 */
	public  $publicKey; // TODO

	/**
	 * @var string
	 */
	public  $secretKey; // TODO

	public function __construct($scenario = '') {
		parent::__construct($scenario);
		$this->loadDefaults();
	}

	public function rules() {
		return [
			['serviceUsername, apiBaseUrl, accessToken', 'required'],
			['serviceUsername', 'match', 'pattern' => '/^[a-z0-9_]+$/', 'allowEmpty' => false],
			['accessToken', 'match', 'pattern' => '/^[a-z0-9]+$/', 'allowEmpty' => false],
			['accessToken', 'length', 'is' => 32],
			['apiBaseUrl', 'length', 'max' => 255, 'allowEmpty' => false],
			['apiBaseUrl', 'default', 'value' => 'http://wowtransfer.com/api/v1'],
			//['publicKey', 'length', 'is' => 16],
			//['secretKey', 'length', 'is' => 32],
		];
	}

	public function attributeLabels() {
		return [
			'serviceUsername' => 'Пользователь',
			'accessToken' => 'Access token',
			'apiBaseUrl' => 'API base URL',
		];
	}

	public function loadDefaults() {
		$filePath = Yii::getPathOfAlias('application') . '/config/service.default.php';
		return parent::loadFromArray(require $filePath);
	}

	public function beforeValidate() {
		$this->apiBaseUrl = YII_DEBUG ? $this->apiBaseUrl : 'http://wowtransfer.com/api/v1';
		return parent::beforeValidate();
	}

	public function load() {
		$filePath = $this->getConfigFilePath();
		if (!file_exists($filePath)) {
			throw new CHttpException(404, 'File not found: ' . $filePath);
		}
		$params = require $filePath;
		if (!is_array($params)) {
			throw new CHttpException(404, 'Is not an array in file ' . $filePath);
		}
		return parent::loadFromArray($params);
	}

	public function save($validate = true) {
		if ($validate && !$this->validate()) {
			return false;
		}
		$filePath = $this->getConfigFilePath();
		if (!file_exists($filePath)) {
			throw new CHttpException(404, 'File not found: ' . $filePath);
		}
		$attributes = ['apiBaseUrl', 'serviceUsername', 'accessToken'];
		$this->setFilePath($filePath);
		$this->setWorkAttributes($attributes);
		$result = parent::save();
		if ($result) {
			Yii::app()->user->setFlash('success', Yii::t('app', 'Configuration of application was changed success.'));
		}
		return $result;
	}

	/**
	 * @return string
	 */
	public function getConfigFilePath() {
		return Yii::getPathOfAlias('application') . '/config/service.php';
	}
}
