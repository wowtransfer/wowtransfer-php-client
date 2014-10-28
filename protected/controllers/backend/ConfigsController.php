<?php

class ConfigsController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionApp()
	{
		$model = new AppConfigForm;
		if (isset($_POST['AppConfigForm']))
		{
			$model->attributes = $_POST['AppConfigForm'];
			if ($model->validate())
				$model->SaveToFile();
		}
		$model->LoadFromFile();
		$model->adminsStr = $model->getAdminsStr();
		$this->render('app', array('model' => $model));
	}

	public function actionToptions()
	{
		$model = new ToptionsConfigForm;
		if (isset($_POST['ToptionsConfigForm']))
		{
			$model->options = $_POST['ToptionsConfigForm'];
			if ($model->validate())
				$model->save();
		}
		$model->load();
		$this->render('toptions', array('options' => $model->options));
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