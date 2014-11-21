<?php

class AppConfigForm extends CFormModel
{
	// virtual attributes
	public $adminsStr = '';
	public $modersStr = '';

	// attributes
	private $admins = array();
	public  $apiBaseUrl = '';
	public  $core = '';
	public  $emailAdmin = '';
	public  $maxTransfersCount = 10;
	public  $maxAccountCharsCount = 10;
	private $moders = array();
	public  $publicKey = ''; // TODO
	public  $serviceUsername = '';
	public  $secretKey = ''; // TODO
	public  $siteUrl = '/';

	public function rules()
	{
		return array(
			array('core, siteUrl, serviceUsername, apiBaseUrl', 'required'),
			array('core, serviceUsername', 'match', 'pattern' => '/^[a-z0-9_]+$/', 'allowEmpty' => false),
			array('maxTransfersCount, maxAccountCharsCount', 'numerical', 'integerOnly' => true, 'min' => 0, 'max' => 1000),
			array('emailAdmin', 'email', 'allowEmpty' => false),
			array('apiBaseUrl', 'length', 'max' => 255, 'allowEmpty' => false),
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
		);
	}

	protected function getConfigFilePath()
	{
		return Yii::getPathOfAlias('application.config') . '/app.php';
	}

	public function save()
	{
		$filePath = $this->getConfigFilePath();
		if (!file_exists($filePath))
			throw new CHttpException(404, 'File not found: ' . $filePath);
		if (!is_writeable($filePath))
			throw new CHttpException(501, 'Couldn\t write to file' . $filePath);

		$file = fopen($filePath, 'w');

		fwrite($file, "<?php\n\nreturn array(\n");

		fwrite($file, "\t'apiBaseUrl'=>'{$this->apiBaseUrl}',\n");
		fwrite($file, "\t'core'=>'{$this->core}',\n");
		fwrite($file, "\t'emailAdmin'=>'{$this->emailAdmin}',\n");
		fwrite($file, "\t'maxTransfersCount'=>{$this->maxTransfersCount},\n");
		fwrite($file, "\t'maxAccountCharsCount'=>{$this->maxAccountCharsCount},\n");
		fwrite($file, "\t'siteUrl'=>'{$this->siteUrl}',\n");
		fwrite($file, "\t'serviceUsername'=>'{$this->serviceUsername}',\n");


		$writeArray = function ($attributeName, $explodeStr) use ($file)
		{
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

		/*$this->admins = explode(',', $this->adminsStr);
		if (!is_array($this->admins))
			$this->admins = array();
		fwrite($file, "\t'admins'=>array(");
		foreach ($this->admins as $value)
			fwrite($file, "'" . trim($value) . "',");
		fwrite($file, "),\n");*/
/*
		// write moderators
		$this->moders = explode(',', $this->modersStr);
		if (!is_array($this->moders))
			$this->moders = array();
		fwrite($file, "\t'moders'=>array(");
		foreach ($this->moders as $value)
			fwrite($file, "'" . trim($value) . "',");
		fwrite($file, "),\n");
*/
		fwrite($file, ");");

		fclose($file);

		Yii::app()->user->setFlash('success', Yii::t('app', 'Configuration of application was changed success.'));
	}

	public function load()
	{
		$filePath = $this->getConfigFilePath();
		if (!file_exists($filePath))
			throw new CHttpException(404, 'File not found: ' . $filePath);

		$config = include $filePath;
		if (!is_array($config))
			throw new CHttpException(404, 'Configuration\' array not found: ' . $filePath);

		foreach ($config as $name => $value)
		{
			if (property_exists($this, $name))
				$this->$name = $value;
		}
		$this->adminsStr = implode(',', $this->admins);
		$this->modersStr = implode(',', $this->moders);

		return true;
	}

	public function getAdminsStr()
	{
		return implode(',', $this->admins);
	}
}