<?php

class AppConfigForm extends CFormModel
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
	 * @var string
	 */
	public  $siteUrl;

	/**
	 * @var array
	 */
	private $admins;

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
	 * @var array
	 */
	private $moders;

	/**
	 * @var string
	 */
	public  $transferTable;

	/**
	 * @var string
	 */
	public  $apiBaseUrl;

	/**
	 * @var string
	 */
	public  $accessToken;

	/**
	 *
	 * @var string
	 */
	public  $serviceUsername;

	/**
	 *
	 * @var string
	 */
	public  $publicKey; // TODO

	/**
	 * @var string
	 */
	public  $secretKey; // TODO

	public function rules()
	{
		return array(
			array('core, siteUrl, serviceUsername, apiBaseUrl, accessToken, transferTable', 'required'),
			array('accessToken', 'match', 'pattern' => '/^[a-z0-9]+$/', 'allowEmpty' => false),
			array('accessToken', 'length', 'is' => 32),
			array('core, serviceUsername', 'match', 'pattern' => '/^[a-z0-9_]+$/', 'allowEmpty' => false),
			array('maxTransfersCount, maxAccountCharsCount', 'numerical', 'integerOnly' => true, 'min' => 0, 'max' => 1000),
			array('emailAdmin', 'email', 'allowEmpty' => false),
			array('apiBaseUrl', 'length', 'max' => 255, 'allowEmpty' => false),
			array('apiBaseUrl', 'default', 'value' => 'http://wowtransfer.com/api/v1'),
			array('secretKey', 'length', 'is' => 32),
			array('transferTable', 'match', 'pattern' => '/^[a-z0-9_]+$/', 'allowEmpty' => false),
			array('adminsStr', 'required'),
			array('modersStr', 'safe'),
			// adminsStr and modersStr have a pattern '\w, \w, \w, \w'
		);
	}

	public function attributeLabels()
	{
		return array(
			'siteUrl' => 'URL сайта',
			'emailAdmin' => 'Email администратора',
			'core' => 'Ядро WoW сервера',
			'maxTransfersCount' => 'Максимальное количество заявок',
			'maxAccountCharsCount' => 'Максимальное количество персонажей на аккаунте',
			'adminsStr' => 'Администраторы',
			'modersStr' => 'Модераторы',
			'serviceUsername' => 'Пользователь',
			'transferTable' => 'Таблица с заявками',
		);
	}

	public function __construct() {
		$this->loadDefaults();
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

		$file = fopen($filePath, 'w');

		fwrite($file, "<?php\n\nreturn array(\n");

		fwrite($file, "\t'apiBaseUrl'=>'{$this->apiBaseUrl}',\n");
		fwrite($file, "\t'core'=>'{$this->core}',\n");
		fwrite($file, "\t'emailAdmin'=>'{$this->emailAdmin}',\n");
		fwrite($file, "\t'maxTransfersCount'=>{$this->maxTransfersCount},\n");
		fwrite($file, "\t'maxAccountCharsCount'=>{$this->maxAccountCharsCount},\n");
		fwrite($file, "\t'siteUrl'=>'{$this->siteUrl}',\n");
		fwrite($file, "\t'serviceUsername'=>'{$this->serviceUsername}',\n");
		fwrite($file, "\t'accessToken'=>'{$this->accessToken}',\n");
		fwrite($file, "\t'transferTable'=>'{$this->transferTable}',\n");

		$writeArray = function ($attributeName, $explodeStr) use ($file) {
			$this->$attributeName = explode(',', $explodeStr);
			if (!is_array($this->$attributeName))
				$this->$attributeName = array();
			fwrite($file, "\t'$attributeName'=>array(");
			foreach ($this->$attributeName as $value)
			{
				$value = trim($value);
				if (!empty($value))
					fwrite($file, "'$value',");
			}
			fwrite($file, "),\n");
		};

		$writeArray('admins', $this->adminsStr);
		$writeArray('moders', $this->modersStr);

		fwrite($file, ");");

		fclose($file);

		Yii::app()->user->setFlash('success', Yii::t('app', 'Configuration of application was changed success.'));
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

		$config =  include $filePath;
		if (!is_array($config)) {
			throw new CHttpException(404, 'Configuration\'s array not found: ' . $filePath);
		}

		return $this->loadFromArray($config);
	}

	/**
	 * @param array $params
	 * @return boolean
	 */
	protected function loadFromArray($params) {
		foreach ($params as $name => $value) {
			if (property_exists($this, $name)) {
				$this->$name = $value;
			}
		}
		$this->adminsStr = implode(',', $this->admins);
		$this->modersStr = implode(',', $this->moders);

		return true;
	}

	/**
	 * @return boolean
	 */
	public function loadDefaults() {
		$defualParams = array(
			// app
			'core' => 'trinity_335a',
			'emailAdmin' => 'admin@example.com',
			'maxTransfersCount' => 5,
			'maxAccountCharsCount' => 10,
			'siteUrl'=>'/',
			'transferTable'=>'chd_transfer',
			'admins'=>array('admin',),
			'moders'=>array(),

			// service
			'apiBaseUrl'=>'http://wowtransfer.com/api/v1',
			'accessToken'=>'',
			'serviceUsername'=>'',
		);

		return $this->loadFromArray($defualParams);
	}

	/**
	 * @return string
	 */
	public function getAdminsStr()
	{
		return implode(',', $this->admins);
	}
}