<?php

class TconfigsController extends Controller
{
	public function actionIndex()
	{
		$service = new Wowtransfer;
		$service->setAccessToken(Yii::app()->params['accessToken']);
		$service->setBaseUrl(Yii::app()->params['apiBaseUrl']);
		
		$models = $service->getTransferConfigs();
		$this->render('index', array('tconfigs' => $models));
	}

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
}