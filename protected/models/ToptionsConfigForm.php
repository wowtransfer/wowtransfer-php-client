<?php
Yii::import('application.models.backend.PhpFileForm');

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
	public static function getConfigFilePath()
	{
		return Yii::getPathOfAlias('application.config') . '/toptions.php';
	}

	/**
	 * @return string
	 */
	public static function getDefaultConfigFilePath() {
		return Yii::getPathOfAlias('application.config') . '/toptions.default.php';
	}

	/**
	 * @return array
	 */
	public static function getTransferOptions() {
		if (self::$transferOptions === null) {
			$options = self::getDynTransferOptions();
			self::$transferOptions = array_merge_recursive(self::getDefaultTransferOptions(), $options);
		}
		return self::$transferOptions;
	}

	/**
	 * @return array
	 * @throws \Exception
	 */
	public static function getDynTransferOptions() {
		$filePath = self::getConfigFilePath();
		if (!file_exists($filePath)) {
			$defaultFilePath = self::getDefaultConfigFilePath();
			copy($defaultFilePath, $filePath);
		}
		$options = require $filePath;
		if (!is_array($options)) {
			throw new Exception('Transfer options is not array: ' . $filePath);
		}
		return $options;
	}

	/**
	 * @return array
	 */
	public static function getDefaultTransferOptions() {
		return [
			'achievement' => array('label' => 'Достижения'),
			'action'      => array('label' => 'Кнопки на панелях'),
			'bind'        => array('label' => 'Бинды'),
			'bag'         => array('label' => 'Вещи в сумках'),
			'bank'        => array('label' => 'Вещи в банке'),
			'criterias'   => array('label' => 'Критерии'),
			'critter'     => array('label' => 'Спутники'),
			'currency'    => array('label' => 'Валюта'),
			'equipment'   => array('label' => 'Наборы экипировки'),
			'glyph'       => array('label' => 'Символы'),
			'inventory'   => array('label' => 'Инвентарь'),
			'mount'       => array('label' => 'Транспорт'),
			'pmacro'      => array('label' => 'Макросы'),
			'quest'       => array('label' => 'Задания'),
			'questlog'    => array('label' => 'Журнал заданий'),
			'reputation'  => array('label' => 'Репутация', ),
			'skill'       => array('label' => 'Навыки (профессии)'),
			'skillspell'  => array('label' => 'Рецепты'),
			'spell'       => array('label' => 'Заклинания'),
			'statistic'   => array('label' => 'Статистика'),
			'talent'      => array('label' => 'Таланты'),
			'taxi'        => array('label' => 'Перелеты'),
			'title'       => array('label' => 'Звания'),
		];
	}

	/**
	 * @param array $options
	 * @param boolean $validate
	 * @return boolean
	 * @throws CHttpException
	 */
	public function saveParams($options, $validate = true)
	{
		$filePath = self::getConfigFilePath();
		if (!file_exists($filePath)) {
			throw new CHttpException(404, 'File not found: ' . $filePath);
		}
		if ($validate && !$this->validate()) {
			return false;
		}
		$this->setFilePath($filePath);
		// Invert options
		$dynOptions = self::getDynTransferOptions();
		$optionsResult = $dynOptions;
		foreach ($dynOptions as $name => $option) {
			$optionsResult[$name]['disabled'] = 1;
		}
		foreach ($options as $name => &$option) {
			if (isset($option['disabled'])) {
				unset($optionsResult[$name]['disabled']);
			}
		}
		Yii::app()->user->setFlash('success', Yii::t('app', 'Transfer options was changed success.'));

		return parent::saveParams($optionsResult);
	}

}