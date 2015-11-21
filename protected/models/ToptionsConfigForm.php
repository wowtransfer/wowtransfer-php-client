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
		return Yii::getPathOfAlias('application.config') . DIRECTORY_SEPARATOR . 'toptions-local.php';
	}

	/**
	 * @return string
	 */
	public static function getDefaultConfigFilePath() {
		return Yii::getPathOfAlias('application.config') . DIRECTORY_SEPARATOR . 'toptions.php';
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
			'achievement' => ['label' => Yii::t('app', 'Achievements')],
			'action'      => ['label' => Yii::t('app', 'Action buttons')],
			'bind'        => ['label' => Yii::t('app', 'Binds')],
			'bag'         => ['label' => Yii::t('app', 'Bag`s items')],
			'bank'        => ['label' => Yii::t('app', 'Bank`s items')],
			'criterias'   => ['label' => Yii::t('app', 'Criterias')],
			'critter'     => ['label' => Yii::t('app', 'Critters')],
			'currency'    => ['label' => Yii::t('app', 'Currency')],
			'equipment'   => ['label' => Yii::t('app', 'Equipment sets')],
			'glyph'       => ['label' => Yii::t('app', 'Glyphs')],
			'inventory'   => ['label' => Yii::t('app', 'Inventory')],
			'mount'       => ['label' => Yii::t('app', 'Mounts')],
			'pmacro'      => ['label' => Yii::t('app', 'Macroses')],
			'quest'       => ['label' => Yii::t('app', 'Quests')],
			'questlog'    => ['label' => Yii::t('app', 'Quest`s log')],
			'reputation'  => ['label' => Yii::t('app', 'Reputation')],
			'skill'       => ['label' => Yii::t('app', 'Skills (professions)')],
			'skillspell'  => ['label' => Yii::t('app', 'Recipes')],
			'spell'       => ['label' => Yii::t('app', 'Spells')],
			'statistic'   => ['label' => Yii::t('app', 'Statistic')],
			'talent'      => ['label' => Yii::t('app', 'Talents')],
			'taxi'        => ['label' => Yii::t('app', 'Taxi')],
			'title'       => ['label' => Yii::t('app', 'Titles')],
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