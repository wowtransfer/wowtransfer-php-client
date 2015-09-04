<?php

class TransfersController extends FrontendController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return [
			['allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => ['index','view','create','update','delete',
					'getCommonFields'
				],
				'users' => array('@'),
			],
			['deny',  // deny all users
				'users'=>array('*'),
			],
		];
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$model->options = str_replace(';', '; ', $model->options); // TODO: hack

		$this->render('view', array(
			'model' => $model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new ChdTransfer;
		$model->setScenario('create');

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		$service = new Wowtransfer();
		$service->setAccessToken(Yii::app()->params['accessToken']);
		$service->setBaseUrl(Yii::app()->params['apiBaseUrl']);

		$request = Yii::app()->request;
		if ($request->getPost('ChdTransfer')) {
			// TODO: exclode 'realmlist', 'realm' and 'username_old'
			$model->attributes = $request->getPost('ChdTransfer');
			$model->fileLua = CUploadedFile::getInstance($model, 'fileLua');
			if ($model->save()) {
				$this->redirect(['view', 'id' => $model->id]);
			}
		}
		else {
			if (empty($model->transferOptions)) {
				$model->transferOptions = Wowtransfer::getDumpFieldsNames();
				$model->options = implode(';', $model->transferOptions);
			}
		}

		$model->pass = '';
		$model->pass2 = '';

		if (defined('YII_DEBUG') && YII_DEBUG) {
			$model->server = 'server';
			$model->account = 'account';
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	public function actionGetCommonFields() {
		$result = [];

		$service = new \Wowtransfer();
		$service->setAccessToken(Yii::app()->params['accessToken']);
		$service->setBaseUrl(Yii::app()->params['apiBaseUrl']);

		try {
			$fileLua = CUploadedFile::getInstanceByName('fileLua');
			if (!$fileLua) {
				throw new Exception('Файл не загружен');
			}
			$dumpContent = file_get_contents($fileLua->tempName);
			$dump = $service->getDump($dumpContent, ['player', 'global']);
			if (!$dump) {
				throw new Exception('Не удалось прочитать lua дамп');
			}
			$result['realmlist'] = $dump['global']['realmlist'];
			$result['realm'] = $dump['global']['realm'];
			$result['username'] = $dump['player']['name'];
		} catch (Exception $ex) {
			$result['error_message'] = $ex->getMessage();
		}

		echo json_encode($result);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id); // TODO: load some fields, without luaDump
		$model->setScenario('update');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['ChdTransfer']))
		{
			if (empty($_POST['ChdTransfer']['transferOptions']))
				$model->addError('transferOptions', Yii::t('app', 'Fill the transfer options'));
			elseif ($model->status !== 'process')
				$model->addError('status', Yii::t('app', 'No change of the request by status'));
			else
			{
				$model->attributes = $_POST['ChdTransfer'];
				//CVarDumper::dump($_POST['ChdTransfer'], 10, true);
				//return;

				if ($model->save())
					$this->redirect(array('index'));
			}
		}

		$serviceUI = new WowtransferUI();
		$serviceUI->setAccessToken(Yii::app()->params['accessToken']);
		$serviceUI->setBaseUrl(Yii::app()->params['apiBaseUrl']);
		$wowServers = $serviceUI->getWowServers();

		$model->pass2 = $model->pass;
		$this->render('update', array(
			'model' => $model,
			'wowServers' => $wowServers,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		if ($model->status !== 'process') {
			$model->addError('status', "Статус заявки не позволяет удалить ее");
		}
		else {
			$model->delete();
		}
		if (Yii::app()->request->isAjaxRequest) {
			$result = array();
			if ($model->hasErrors()) {
				$errors = $model->getErrors(); // TODO: this is hard way to get an error
				$error = reset($errors);
				$result['error'] = $error[0];
			}
			else {
				$result['message'] = 'Заявка успешно удалена';
			}

			echo json_encode($result);
			Yii::app()->end();
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax'])) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('ChdTransfer', array(
			'criteria' => array(
				'condition' => 'account_id=' . Yii::app()->user->id . " AND status <> 'cart'",
			),
		));
		if (Yii::app()->request->isAjaxRequest) {
			$this->renderPartial('_list', array(
				'dataProvider'=>$dataProvider,
			));
			Yii::app()->end();
		}

		$this->render('index', array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ChdTransfer the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = ChdTransfer::model()->findByPk($id,
			'account_id=' . Yii::app()->user->id . " AND status <> 'cart'"
		);
		if ($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		if (!empty($model->options))
		{
			$model->transferOptions = explode(';', $model->options);
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ChdTransfer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'chd-transfer-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
