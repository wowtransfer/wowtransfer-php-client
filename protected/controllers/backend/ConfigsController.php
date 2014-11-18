<?php

class ConfigsController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionApp()
	{
		$serviceUI = new WowtransferUI;
		$model = new AppConfigForm;
		if (isset($_POST['AppConfigForm']))
		{
			$model->attributes = $_POST['AppConfigForm'];
			if ($model->validate())
				$model->save();
		}
		else
		{
			$model->load();
		}
		$model->adminsStr = $model->getAdminsStr();
		$this->render('app', array(
			'model' => $model,
			'cores' => $serviceUI->getCores(),
		));
	}

	public function actionToptions()
	{
		$model = new ToptionsConfigForm;

		if (isset($_POST['toptions']))
		{
			//CVarDumper::dump($_POST, 10, true);
			$model->options = $_POST['toptions'];
			if ($model->validate())
				$model->save();
		}
		$model->load();
		$this->render('toptions', array(
			'options' => $model->options,
		));
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