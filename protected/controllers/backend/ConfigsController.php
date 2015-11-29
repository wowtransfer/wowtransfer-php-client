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

		$service = new WowtransferUI();

		$this->render('app', array(
			'model' => $model,
			'cores' => $service->getCoresPair(),
		));
	}

	public function actionToptions()
	{
		$request = Yii::app()->request;
		$model = new ToptionsConfigForm;

		if ($request->getPost('toptions')) {
			$options = $request->getPost('toptions');
			$model->saveParams($options);
		}
		$this->render('toptions', [
			'options' => TransferOptions::getOptions(),
		]);
	}

	public function actionRemoteServers() {
		$service = new \WowtransferUI();
		$wowServers = $service->getWowServers();
		$remoteServersForm = new RemoteServersForm();
		$remoteServersForm->load();
		$blackRealms = $remoteServersForm->getRealmsIds();

		$request = Yii::app()->request;
		if ($request->isPostRequest) {
			$blackRealms = array_keys((array)$request->getPost('realms'));
			$remoteServersForm->setRealmsIds($blackRealms);
			if ($remoteServersForm->save()) {
				Yii::app()->user->setFlash('success', Yii::t('app', 'Success changed'));
			}
			else {
				Yii::app()->user->setFlash('error', Yii::t('app', 'Saving failed'));
			}
		}

		$this->render('remoteservers', array(
			'wowServers' => $wowServers,
			'blackRealms' => $blackRealms,
		));
	}

	public function actionService() {
		$request = Yii::app()->request;
		$model = new ServiceConfigForm();

		if ($request->getQuery('default')) {
			$model->loadDefaults();
			if ($model->save(false)) {
				$this->redirect(['/configs/service']);
			}
		}
		if ($request->getPost('ServiceConfigForm')) {
			$model->attributes = $request->getPost('ServiceConfigForm');
			$model->save();
		}
		$model->load();

		$this->render('service', [
			'model' => $model,
		]);
	}

	public function actionDb() {
		$request = Yii::app()->request;
		$model = new DbConfigForm();


		if ($request->getPost('DbConfigForm')) {
			$model->attributes = $request->getPost('DbConfigForm');
			$model->save();
		}

		$this->render('db', [
			'model' => $model,
		]);
	}
}