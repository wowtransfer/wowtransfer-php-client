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
	public  $siteUrl;

	/**
	 * @var string
	 */
	public  $core;

	/**
	 * @var string
	 */
	public  $emailAdmin;

	/**
	 * @var integer
	 */
	public  $maxTransfersCount;

	/**
	 * @var integer 
	 */
	public  $maxAccountCharsCount;

	/**
	 * @var string
	 */
	public  $transferTable;

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
		];
	}

	public function attributeLabels()
	{
		return [
			'siteUrl'              => 'URL сайта',
			'emailAdmin'           => 'Email администратора',
			'core'                 => 'Ядро WoW сервера',
			'maxTransfersCount'    => 'Максимальное количество заявок',
			'maxAccountCharsCount' => 'Максимальное количество персонажей на аккаунте',
			'adminsStr'            => 'Администраторы',
			'modersStr'            => 'Модераторы',
			'transferTable'        => 'Таблица с заявками',
		];
	}

	/**
	 * @return string
	 */
	protected function getConfigFilePath()
	{
		return Yii::getPathOfAlias('application.config') . '/app.php';
	}

	/**
	 * @throws CHttpException
	 */
	public function save()
	{
		$filePath = $this->getConfigFilePath();
		if (!file_exists($filePath)) {
			throw new CHttpException(404, 'File not found: ' . $filePath);
		}

		$attributes = [
			'siteUrl', 'emailAdmin', 'core', 'maxTransfersCount',
			'maxAccountCharsCount', 'admins', 'moders', 'transferTable',
		];
		$this->setFilePath($filePath);
		$this->setWorkAttributes($attributes);
		$result = parent::save();
		if ($result) {
			Yii::app()->user->setFlash('success', Yii::t('app', 'Configuration of application was changed success.'));
		}
		return $result;
	}

	/**
	 * @return boolean
	 * @throws CHttpException
	 */
	public function load() {
		$filePath = $this->getConfigFilePath();
		if (!file_exists($filePath)) {
			throw new CHttpException(404, 'File not found: ' . $filePath);
		}

		$config = require $filePath;
		if (!is_array($config)) {
			throw new CHttpException(404, 'Configuration\'s array not found: ' . $filePath);
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
		$defualParams = array(
			'core' => 'trinity_335a',
			'emailAdmin' => 'admin@example.com',
			'maxTransfersCount' => 5,
			'maxAccountCharsCount' => 10,
			'siteUrl'=>'/',
			'transferTable'=>'chd_transfer',
			'admins'=>array('admin'),
			'moders'=>array(),
		);

		return $this->loadFromArray($defualParams);
	}
}