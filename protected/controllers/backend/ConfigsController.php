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
		$model = new AppConfigForm;

		if (Yii::app()->request->getQuery('default')) {
			$model->loadDefaults();
			$model->save();
			$this->redirect($this->createUrl('/configs/app'));
		}
		// TODO: server and service submit
		if (isset($_POST['AppConfigForm'])) {
			$model->attributes = $_POST['AppConfigForm'];
			if ($model->validate()) {
				$model->save();
			}
		}
		else {
			$model->load();
		}

		try {
			$serviceUI = new WowtransferUI();
			$serviceUI->setAccessToken(Yii::app()->params['accessToken']);
			$serviceUI->setBaseUrl(Yii::app()->params['apiBaseUrl']);
			$cores = $serviceUI->getCores();
		}
		catch (Exception $e) {
			$cores = array(); // TODO: display message
		}

		$model->adminsStr = $model->getAdminsStr();
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
}