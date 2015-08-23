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
		return Yii::getPathOfAlias('application.config') . '/toptions-local.php';
	}

	/**
	 * @return string
	 */
	public static function getDefaultConfigFilePath() {
		return Yii::getPathOfAlias('application.config') . '/toptions.php';
	}

	/**
	 * @return array
	 */
	public static function getTransferOptions() {
		if (self::$transferOptions === null) {
			$options = self::getLocalTransferOptions();
			$localOptions = array_merge_recursive(self::getDefaultTransferOptions(), self::getTransferOptionsUI());
			self::$transferOptions = array_merge_recursive($localOptions, $options);
		}
		return self::$transferOptions;
	}

	/**
	 * @return array
	 * @throws \Exception
	 */
	public static function getLocalTransferOptions() {
		$filePath = self::getConfigFilePath();
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
		$filePath = self::getDefaultConfigFilePath();
		return require $filePath;
	}

	/**
	 * @return array
	 */
	public static function getTransferOptionsUI() {
		return [
			'achievement' => ['label' => 'Достижения'],
			'action'      => ['label' => 'Кнопки на панелях'],
			'bind'        => ['label' => 'Бинды'],
			'bag'         => ['label' => 'Вещи в сумках'],
			'bank'        => ['label' => 'Вещи в банке'],
			'criterias'   => ['label' => 'Критерии'],
			'critter'     => ['label' => 'Спутники'],
			'currency'    => ['label' => 'Валюта'],
			'equipment'   => ['label' => 'Наборы экипировки'],
			'glyph'       => ['label' => 'Символы'],
			'inventory'   => ['label' => 'Инвентарь'],
			'mount'       => ['label' => 'Транспорт'],
			'pmacro'      => ['label' => 'Макросы'],
			'quest'       => ['label' => 'Задания'],
			'questlog'    => ['label' => 'Журнал заданий'],
			'reputation'  => ['label' => 'Репутация', ],
			'skill'       => ['label' => 'Навыки (профессии)'],
			'skillspell'  => ['label' => 'Рецепты'],
			'spell'       => ['label' => 'Заклинания'],
			'statistic'   => ['label' => 'Статистика'],
			'talent'      => ['label' => 'Таланты'],
			'taxi'        => ['label' => 'Перелеты'],
			'title'       => ['label' => 'Звания'],
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

		$localOptions = self::getDefaultTransferOptions();
		foreach ($localOptions as $name => $option) {
			$localOptions[$name]['disabled'] = 1;
		}
		// Invert options
		foreach ($options as $name => &$option) {
			if (isset($option['disabled'])) {
				unset($localOptions[$name]['disabled']);
			}
		}
		Yii::app()->user->setFlash('success', Yii::t('app', 'Transfer options was changed success.'));

		return parent::saveParams($localOptions);
	}

}