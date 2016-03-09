<?php

/**
 * Options of the transfer
 */
class TransferOptions
{
	/**
	 * @var array
	 */
	protected static $options;

	/**
	 * @return array
	 */
	public static function getOptions() {
		if (self::$options === null) {
			$options = Config::getInstance()->getTransferOptions();
			$optionsUI = self::getTransferOptionsUI();
			self::$options = array_merge_recursive($options, $optionsUI);
			//var_dump(self::$options); die;
		}
		return self::$options;
	}

	/**
	 * @return array Key - option's name, Value - option's title
	 */
	public static function getOptionsPair()
	{
		$options = [];

		foreach (self::getOptions() as $name => $option) {
			$options[$name] = $option['label'];
		}

		return $options;
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
}
