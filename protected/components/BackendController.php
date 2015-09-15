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