<?php

/**
 * Main class of wowtransfer.com service
 */
class Wowtransfer
{
	/**
	 * @return array Transfer's options
	 * @todo Make loading from wowtransfer.com
	 *       Make locale
	 */
	public static function getTransferOptions()
	{
		return array(
			'achievement' => array('label' => 'Достижения'),
			'action'      => array('label' => 'Кнопки на панелях'),
			'bind'        => array('label' => 'Бинды'),
			'bag'         => array('label' => 'Вещи в сумках'),
			'bank'        => array('label' => 'Вещи в банке'),
			'criterias'   => array('label' => 'Критерии к достижениям'),
			'critter'     => array('label' => 'Спутники'),
			'currency'    => array('label' => 'Валюта'),
			'equipment'   => array('disabled' => 1, 'label' => 'Наборы экипировки'),
			'glyph'       => array('label' => 'Символы'),
			'inventory'   => array('label' => 'Инвентарь'),
			'mount'       => array('label' => 'Транспорт'),
			'pmacro'      => array('disabled' => 1, 'label' => 'Макросы'),
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
		);
	}

	public function getApiVersion()
	{
		return '1.0';
	}

	public function getAddonVersion()
	{
		return '1.11';
	}

	public function getChdphpVersion()
	{
		return '1.0';
	}

	public function dumjpToSql()
	{
		return 'TODO: in process...';
	}
}