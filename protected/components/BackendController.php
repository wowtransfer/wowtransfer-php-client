<?php

class BackendController extends BaseController
{
	public $layout = '//layouts/column1';

	/**
	 * FIlters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * 
	 */
	public function accessRules()
	{
		return array(
			// only admin
			array(
				'allow',
				'roles'=>array('admin'),
			),
			// login.php allow view
			array(
				'allow',
				'actions'=>array('login'),
				'users'=>array('?'),
			),
			array(
				'allow',
				'actions'=>array('error'),
				'users'=>array('*'),
			),
			// deny from all
			array(
				'deny',
				'users'=>array('*'),
			), 
		);
	}

	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			}
			else {
				if (Yii::app()->user->isAdmin()) {
					$this->render('error', $error);
				}
				else {
					$this->redirect(Yii::app()->request->baseUrl);
				}
			}
		}
	}

	/**
	 * @return array
	 */
	public function getMainMenuItems() {
		$items = [
			[
				'label' => Yii::t('app', 'Site'),
				'url' => Config::getInstance()->getSiteUrl(),
				'icon' => 'home'
			],
			[
				'label' => Yii::t('zii', 'Home'),
				'url'=>['/'],
				'active' => $this->route == 'site/index'
			],
			[
				'label' => Yii::t('app', 'Requests'),
				'url'=>['/transfers'],
				'visible' => !Yii::app()->user->isGuest,
				'active' => $this->id == 'transfers', 'icon' => 'list'
			],
			[
				'label' => Yii::t('app', 'Characters'),
				'url' => ['/characters'],
			],
			[
				'label' => Yii::t('app', 'Configurations'),
				'url' => ['/tconfigs/index'],
				'icon' => 'asterisk'],
			[
				'label' => Yii::t('app', 'Settings'),
				'url' => ['/configs'],
				'icon' => 'cog',
				'active' => $this->id == 'configs'],
			[
				'label' => Yii::t('app', 'Update'),
				'url' => ['/updates'],
				'icon' => 'ok-circle',
				'active' => $this->id == 'updates'
			],
		];

		return $items;
	}

	/**
	 * @return array
	 */
	public function getRightMenuItems() {
		$lang = Yii::app()->language;
		$items = [
			[
				'label' => 'F',
				'url' => Yii::app()->request->baseUrl . '/index.php/transfers/index',
				'visible' => Yii::app()->user->isAdmin(),
				'icon' => 'share-alt',
				'htmlOptions' => ['title' => Yii::t('app', 'Application')],
				'linkOptions' => ['id' => 'to-frontend'],
			],
			[
				'label' => '<span class="spr flag-' . $lang . '"></span>',
				'items' => [
					[
						'url' => ['/site/lang', 'lang' => 'ru'],
						'label' => '<span class="spr flag-ru"></span>',
						'active' => $lang === 'ru',
					],
					[
						'url' => ['/site/lang', 'lang' => 'en'],
						'label' => '<span class="spr flag-en"></span>',
						'active' => $lang === 'en',
					],
				]
			],
			[
				'label' => Yii::app()->user->name,
				'visible' => !Yii::app()->user->isGuest,
				'items' => [
					[
						'url' => ['/site/logout'],
						'label' => Yii::t('app', 'Logout'),
						'icon' => 'log-out',
					],
				]
			],
			[
				'url' => ['/site/login'],
				'label' => Yii::t('app', 'Login'),
				'visible' => Yii::app()->user->isGuest && $this->route !== 'site/login',
				'icon' => 'log-in',
			],
		];

		return $items;
	}


	/**
	 * @todo minify
	 */
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
			$cs->registerCssFile($baseUrl . '/css/dev/backend/backend.css');

			$cs->registerScriptFile($baseUrl . '/js/dev/backend/main.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/common/common.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/common/dialogs.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/backend/updates.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/backend/transfers/transfers.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/backend/transfers/characters.js', CClientScript::POS_END);
			$cs->registerScriptFile($baseUrl . '/js/dev/backend/transfers/luadumps.js', CClientScript::POS_END);
		}
		else {
			$cs->registerScriptFile($baseUrl . '/js/backend.min.js', CClientScript::POS_END);
		}
	}

	/**
	 * @return boolean
	 */
	public function isServiceLogined() {

		return false;
	}
}