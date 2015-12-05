<?php

class ToptionsConfigForm extends PhpFileForm
{
	/**
	 * @var array
	 */
	private static $transferOptions;

	public function rules()
	{
		return [

		];
	}

	public function attributeLabels()
	{
		return [

		];
	}

	/**
	 * @return string
	 */
	protected function getConfigFilePath()
	{
		return Yii::getPathOfAlias('application.config') . DIRECTORY_SEPARATOR . 'toptions-local.php';
	}

	/**
	 * @return string
	 */
	protected function getDefaultConfigFilePath()
	{
		return Yii::getPathOfAlias('application.config') . DIRECTORY_SEPARATOR . 'toptions.php';
	}

	/**
	 * @return array
	 */
	public function getDefaultTransferOptions()
	{
		$filePath = $this->getDefaultConfigFilePath();
		return require $filePath;
	}

	/**
	 * @param array $options
	 * @param boolean $validate
	 * @return boolean
	 * @throws CHttpException
	 */
	public function saveParams($options, $validate = true)
	{
		$filePath = $this->getConfigFilePath();
		if (!file_exists($filePath)) {
			throw new CHttpException(404, 'File not found: ' . $filePath);
		}
		if ($validate && !$this->validate()) {
			return false;
		}
		$this->setFilePath($filePath);

		$localOptions = self::getDefaultTransferOptions();
		foreach ($localOptions as $name => $option) {
			$localOptions[$name]['disabled'] = 1;
		}
		// Invert options
		foreach ($options as $name => $option) {
			if (isset($option['disabled'])) {
				unset($localOptions[$name]['disabled']);
			}
		}
		Yii::app()->user->setFlash('success', Yii::t('app', 'Transfer options was changed success.'));

		return parent::saveParams($localOptions);
	}

}