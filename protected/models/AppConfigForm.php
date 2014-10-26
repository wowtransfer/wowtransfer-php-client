<?php

class AppConfigForm extends CFormModel
{
	private $admins = array();
	private $moders = array();

	public $adminsStr = '';
	public $moderatorsStr = '';
	public $siteUrl = '';
	public $apiBaseUrl = '';
	public $emailAdmin = '';
	public $core = '';
	public $maxTransfersCount = 0;
	public $maxAccountCharCount = 0;

	public function rules()
	{
		return array(
			array('core', 'required'),
			array('siteUrl, apiBaseUrl, emailAdmin, maxTransfersCount, maxAccountCharCount', 'safe'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'siteUrl' => 'URL сайта',
			'emailAdmin' => 'Email администратора',
			'core' => 'Ядро WoW сервера',
			'maxTransfersCount' => 'Максимальное количество заявок',
			'maxAccountCharCount' => 'Максимальное количество персонажей на аккаунте',
		);
	}

	protected function getConfigFilePath()
	{
		return Yii::getPathOfAlias('application.config') . '/app.php';
	}

	public function SaveToFile()
	{
		$filePath = $this->getConfigFilePath();
		if (!file_exists($filePath))
			throw new CHttpException(404, 'File not found: ' . $filePath);

		$file = fopen($filePath, 'w');
		if (!$file)
			throw new CHttpException(501, 'Couldn\t write to file' . $filePath);

		fwrite($file, "<?php\n\nreturn array(\n");
		foreach ($this->attributes as $name => $value)
		{
			fwrite($file, "\t'$name'=>'$value',// 1\n");
		}
		fwrite($file, ");");

		fclose($file);

		Yii::app()->user->setFlash('success', Yii::t('app', 'Configuration of application was changed success.'));
	}

	public function LoadFromFile()
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

		return true;
	}

	public function getAdminsStr()
	{
		return implode(',', $this->admins);
	}

	public function getCores()
	{
		$service = new Wowtransfer();
		$cores = $service->getCores();
		if (!$cores || !is_array($cores))
			return false;

		$result = array();
		foreach ($cores as $core)
			$result[$core['name']] = $core['title'];

		return $result;
	}
}