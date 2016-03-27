<?php

class SiteController extends BackendController
{
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionLogin()
	{
		$this->redirect(Yii::app()->baseUrl . '/');
	}

	public function actionLogout()
	{
		$this->redirect(Yii::app()->baseUrl . '/index.php/site/logout');
	}
}