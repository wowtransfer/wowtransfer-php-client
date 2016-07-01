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
		return [
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		];
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
				'users' => ['@'],
			],
			['deny',  // deny all users
				'users' => ['*'],
			],
		];
	}

	public function beforeAction($action)
	{
		try {
			$query = "SELECT id FROM chd_transfer ct LIMIT 1";
			$command = Yii::app()->db->createCommand($query);
			$command->queryScalar();
		} catch (CDbException $ex) {
			if (preg_match("/Table(.+)doesn't exist/i", $ex->getMessage())) {
				$message = 'The application is not set up. The transfer table is not found.';
				throw new \Exception(Yii::t('app', $message));
			}
			else {
				throw $ex;
			}
		}
		return parent::beforeAction($action);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);

		$this->render('view', [
			'model' => $model,
		]);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new ChdTransfer;
		$model->setScenario('create');
		$service = new WowtransferUI();

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

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
				$model->transferOptions = $service->getDumpsFields();
				$model->options = implode(';', $model->transferOptions);
			}
		}

		$model->pass = '';
		$model->pass2 = '';

		$this->render('create', [
			'model' => $model,
			'wowserversSites' => $service->getWowServersSites(),
			'wowserversPair' => $service->getWowServersPair(),
		]);
	}

	public function actionGetCommonFields()
	{
		$result = [];

		$service = new \WowtransferUI();

		try {
			$fileLua = CUploadedFile::getInstanceByName('fileLua');
			if (!$fileLua) {
				throw new Exception(Yii::t('File not uploaded'));
			}
			$dumpContent = file_get_contents($fileLua->tempName);
			$dump = $service->getDump($dumpContent, ['player', 'global']);
			if (!$dump) {
				throw new Exception(Yii::t('Could not read dump'));
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

		if (isset($_POST['ChdTransfer'])) {
			if (empty($_POST['ChdTransfer']['transferOptions'])) {
				$model->addError('transferOptions', Yii::t('app', 'Fill the transfer options'));
			}
			elseif ($model->status !== 'process') {
				$model->addError('status', Yii::t('app', 'No change of the request by status'));
			}
			else {
				$model->attributes = $_POST['ChdTransfer'];
				if ($model->save()) {
					$this->redirect(['index']);
				}
			}
		}

		$service = new WowtransferUI();

		$model->pass2 = $model->pass;
		$this->render('update', [
			'model' => $model,
			'wowserversSites' => $service->getWowServersSites(),
			'wowserversPair' => $service->getWowServersPair(),
		]);
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

		$request = Yii::app()->request;
		$returnUrl = $request->getPost('returnUrl') ? $request->getPost('returnUrl') : $this->createUrl('/transfers/index');

		if (Yii::app()->request->isAjaxRequest) {
			$result = [];
			if ($model->hasErrors()) {
				$errors = $model->getErrors(); // TODO: this is hard way to get an error
				$error = reset($errors);
				$result['error'] = $error[0];
			}
			else {
				$result['message'] = Yii::t('app', 'Success deleting');
				$result['returnUrl'] = $returnUrl;
			}

			echo json_encode($result);
			Yii::app()->end();
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax'])) {
			$this->redirect($returnUrl);
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('ChdTransfer', [
			'criteria' => [
				'condition' => 'account_id=' . Yii::app()->user->id . " AND status <> 'cart'",
			],
		]);
		if (Yii::app()->request->isAjaxRequest) {
			$this->renderPartial('_list', [
				'dataProvider'=>$dataProvider,
			]);
			Yii::app()->end();
		}

		$this->render('index', [
			'dataProvider'=>$dataProvider,
		]);
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
		if ($model === null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		if (!empty($model->options)) {
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
		if (Yii::app()->request->getPost('ajax') === 'chd-transfer-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
