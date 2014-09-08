<?php

class ConfigsController extends Controller
{
	public function actionIndex()
	{
		$model = new AppConfigForm;
		if (isset($_POST['AppConfigForm']))
		{
			$model->attributes = $_POST['AppConfigForm'];
			if ($model->validate())
				$model->SaveToFile();
		}
		$model->LoadFromFile();
		$this->render('index', array('model' => $model));
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