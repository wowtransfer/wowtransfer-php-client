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
			'achievement' => array('enable' => 1, 'title' => 'Достижения'),
			'action'      => array('enable' => 1, 'title' => 'Кнопки на панелях'),
			'bind'        => array('enable' => 1, 'title' => 'Бинды'),
			'bag'         => array('enable' => 1, 'title' => 'Вещи в сумках'),
			'bank'        => array('enable' => 1, 'title' => 'Вещи в банке'),
			'criterias'   => array('enable' => 1, 'title' => 'Критерии к достижениям'),
			'critter'     => array('enable' => 1, 'title' => 'Спутники'),
			'currency'    => array('enable' => 1, 'title' => 'Валюта'),
			'equipment'   => array('enable' => 0, 'title' => 'Наборы экипировки'),
			'glyph'       => array('enable' => 1, 'title' => 'Символы'),
			'inventory'   => array('enable' => 1, 'title' => 'Инвентарь'),
			'mount'       => array('enable' => 1, 'title' => 'Транспорт'),
			'pmacro'      => array('enable' => 0, 'title' => 'Макросы'),
			'quest'       => array('enable' => 1, 'title' => 'Задания'),
			'questlog'    => array('enable' => 1, 'title' => 'Журнал заданий'),
			'reputation'  => array('enable' => 1, 'title' => 'Репутация', ),
			'skill'       => array('enable' => 1, 'title' => 'Навыки (профессии)'),
			'skillspell'  => array('enable' => 1, 'title' => 'Рецепты'),
			'spell'       => array('enable' => 1, 'title' => 'Заклинания'),
			'statistic'   => array('enable' => 1, 'title' => 'Статистика'),
			'talent'      => array('enable' => 1, 'title' => 'Таланты'),
			'taxi'        => array('enable' => 1, 'title' => 'Перелеты'),
			'title'       => array('enable' => 1, 'title' => 'Звания'),
		);
	}
}