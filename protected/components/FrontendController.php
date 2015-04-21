<?php

class FrontEndController extends BaseController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * Return menu data
	 *
	 * @return array
	 */
	public function getMenu() {
		$menu = array();

		$menu[] = array('label' => 'Сайт', 'url' => Yii::app()->params['siteUrl'], 'icon' => 'home');
		if (Yii::app()->user->isGuest) {
			$menu[] = array('label' => 'Войти', 'url' => array('/site/login'), 'icon' => 'login');
		}
		else {
			$menu[] = array(
				'label' => 'Заявки', 'url' => array('/transfers'),
				'icon' => 'list', 'active' => $this->id == 'transfers',
			);
		}
		$menu[] = array('label' => 'Помощь', 'url' => array('/site/page'), 'icon' => 'info-sign');

		return $menu;
	}
}