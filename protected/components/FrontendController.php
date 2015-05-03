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

	public function registerCssAndJs() {
		$cs = Yii::app()->clientScript;
		$baseUrl = Yii::app()->request->baseUrl;

		if (YII_DEBUG) {
			// blueprint CSS framework
			$cs->registerCssFile($baseUrl . '/css/dev/common/main.css', 'screen, projection');
			$cs->registerCssFile($baseUrl . '/css/dev/common/print.css', 'print');
			/*
			<!--[if lt IE 8]>
			<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
			<![endif]-->
			*/
			$cs->registerCssFile($baseUrl . '/css/dev/common/main.css');
			$cs->registerCssFile($baseUrl . '/css/dev/common/form.css');

			Yii::app()->bootstrap->register();

			$cs->registerCssFile($baseUrl . '/css/dev/common/common.css');
			$cs->registerCssFile($baseUrl . '/css/dev/common/sprite_main.css');
			$cs->registerCssFile($baseUrl . '/css/dev/frontend/frontend.css');

			$cs->registerScriptFile($baseUrl . '/js/dev/common/common.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/frontend/main.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/frontend/transfers.js', CClientScript::POS_END);
		}
		else {
			$cs->registerScriptFile($baseUrl . '/js/fronend.min.js', CClientScript::POS_END);
		}
	}
}