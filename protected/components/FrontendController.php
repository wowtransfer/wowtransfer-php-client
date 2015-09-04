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

		$menu[] = array('label' => Yii::t('app', 'Site'), 'url' => Yii::app()->params['siteUrl'], 'icon' => 'home');
		if (Yii::app()->user->isGuest) {
			$menu[] = array('label' => Yii::t('app', 'Login'), 'url' => array('/site/login'), 'icon' => 'login');
		}
		else {
			$menu[] = array(
				'label' => Yii::t('app', 'Requests'), 'url' => array('/transfers'),
				'icon' => 'list', 'active' => $this->id == 'transfers',
			);
		}
		$menu[] = array('label' => Yii::t('app', 'Help'), 'url' => array('/site/page'), 'icon' => 'info-sign');

		return $menu;
	}

	public function registerCssAndJs() {
		$cs = Yii::app()->clientScript;
		$baseUrl = Yii::app()->request->baseUrl;

		if (true) { // TODO: minify resource
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
			$cs->registerCssFile($baseUrl . '/css/dev/common/icons.css');
			$cs->registerCssFile($baseUrl . '/css/dev/common/sprite_main.css');
			$cs->registerCssFile($baseUrl . '/css/dev/frontend/frontend.css');

			$cs->registerScriptFile($baseUrl . '/js/dev/frontend/main.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/common/common.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/common/dialogs.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/frontend/transfers.js', CClientScript::POS_END);
		}
		else {
			$cs->registerScriptFile($baseUrl . '/js/frontend.min.js', CClientScript::POS_END);
		}
	}
}