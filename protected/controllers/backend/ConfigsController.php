<?php

class ConfigsController extends BackendController
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

	public function actionApp()
	{
		$request = Yii::app()->request;
		$model = new AppConfigForm();

		if ($request->getQuery('default')) {
			$model->loadDefaults();
			$model->save(false);
			$this->redirect($this->createUrl('/configs/app'));
		}
		if ($request->getPost('AppConfigForm')) {
			$model->attributes = $request->getPost('AppConfigForm');
			$model->adminsFromUser();
			$model->modersFromUser();
			$model->save();
		}
		else {
			$model->load();
		}

		$serviceUI = new WowtransferUI();
		$serviceUI->setAccessToken(Yii::app()->params['accessToken']);
		$serviceUI->setBaseUrl(Yii::app()->params['apiBaseUrl']);
		$cores = $serviceUI->getCores();

		$this->render('app', array(
			'model' => $model,
			'cores' => $cores,
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

	public function actionRemoteServers() {
		$wowtransfer = new \Wowtransfer();
		$wowtransfer->setBaseUrl(Yii::app()->params['apiBaseUrl']);
		$blackServers = $wowtransfer->getWowServers();
		$whiteServers = array();

		$this->render('remoteservers', array(
			'whiteservers' => $whiteServers,
			'blackServers' => $blackServers,
		));
	}

	public function actionService() {
		$request = Yii::app()->request;
		$model = new ServiceConfigForm();

		if ($request->getQuery('default')) {
			$model->loadDefaults();
			if ($model->save(false)) {
				$this->redirect($this->createUrl('/configs/service'));
			}
		}
		if ($request->getPost('ServiceConfigForm')) {
			$model->attributes = $request->getPost('ServiceConfigForm');
			$model->save();
		}
		else {
			$model->load();
		}

		$this->render('service', [
			'model' => $model,
		]);
	}
}