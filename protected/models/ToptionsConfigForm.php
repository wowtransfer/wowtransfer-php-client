<?php

class ToptionsConfigForm extends CFormModel
{
	public $options = array();

	public function rules()
	{
		return array(
		
		);
	}

	public function attributeLabels()
	{
		return array(
			'options' => 'Опции переноса',
		);
	}

	public static function getConfigFilePath()
	{
		return Yii::getPathOfAlias('application.config') . '/toptions.php';
	}

	public static function getDefaultTransferOptions()
	{
		
	} 

	public function save()
	{
		$filePath = self::getConfigFilePath();
		if (!file_exists($filePath))
			throw new CHttpException(404, 'File not found: ' . $filePath);

		$file = fopen($filePath, 'w');
		if (!$file)
			throw new CHttpException(501, 'Couldn\t write to file' . $filePath);

		fwrite($file, "<?php\n\nreturn array(\n");
		foreach ($this->options as $name => $option)
		{
			$label = isset($option['label']) ? $option['label'] : '';
			fprintf($file, "\t%12s=>array(");
			if (isset($option['disabled']))
				fwrite($file, 'disabled=>1,');
			fwrite($file, "'label'=>'$label'),\n", $name);
		}
		fwrite($file, ");");

		fclose($file);

		return true;
	}

	public function load()
	{
		$filePath = self::getConfigFilePath();
		if (!file_exists($filePath))
			throw new CHttpException(404, 'File not found: ' . $filePath);

		$options = include $filePath;
		if (!is_array($options))
			throw new CHttpException(404, 'Transfer options is not array: ' . $filePath);

		/*foreach ($options as $name => $option)
		{
			if (property_exists($this, $name))
				$this->$name = $value;
		}*/
		$this->options = $options;

		return true;
	}
}