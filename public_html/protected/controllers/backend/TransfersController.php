<?php

class TransfersController extends BackendController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * For filter
	 * @var integer $filterDt
	 * @var array|false $filterStatuses
	 */
	public $filterDtRange;
	public $filterStatuses;

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return [
			['allow',
				'actions' => [
					'admin','index','view','update','delete',
					'char','deletechar','luadump','filter', 'remotepassword', 'onlysql',
					'changeview',
				],
				'roles' => ['admin'],
			],
			['deny',  // deny all users
				'users' => ['*'],
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

		$this->render('view', [
			'model' => $model,
		]);
	}

	/**
	 * Updates a particular model.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (Yii::app()->request->isAjaxRequest && !empty($_POST)) {
			$model = $this->loadModel($id);
			$model->setScenario('update');
			$model->attributes = $_POST;
			if (!$model->save(true, array_keys($_POST))) {
				throw new CHttpException(501, 'Error');
			}
			Yii::app()->end();
		}
		$this->redirect(['index']);
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['admin']);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex() {
		$filter = [];
		$request = Yii::app()->request;

		if ($request->isAjaxRequest) {
			$filter = $_POST;
		}
		elseif ($request->cookies['chd_transfer_filter']) {
			$filter = unserialize($request->cookies['chd_transfer_filter']);
		}

		$statuses = isset($filter['statuses']) ? $filter['statuses'] : [];
		$dtRange = isset($filter['dt_range']) ? (int)$filter['dt_range'] : 0;
		if ($statuses) {
			$statusesOrigin = ChdTransfer::getStatuses();
			if (count($statusesOrigin) === count($statuses)) {
				$statuses = [];
				$filter['statuses'] = $statuses;
			}
		}
		$this->filterStatuses = $statuses;
		$this->filterDtRange = $dtRange;

		$where = '1=1';
		if ($dtRange > 0) {
			$where .= " AND `create_transfer_date` > '" . date('Y-m-d', strtotime("-$dtRange days")) . "'";
		}
		if (!empty($statuses)) {
			for ($i = 0; $i < count($statuses); ++$i) {
				$statuses[$i] = "'" . $statuses[$i] . "'";
			}
			$where .= " AND `status` IN (" . implode(',', $statuses) . ")";
		}

		$dataProvider = new CActiveDataProvider('ChdTransfer', [
			'criteria' => [
				'select' => '*',
				'condition' => $where,
			],
		]);

		$filterBlock = $this->renderPartial('_filter_form', null, true);
		$this->addAsideBlockToColumn2($filterBlock);

		$viewMode = $this->getViewMode();
		$viewParams = [
			'dataProvider' => $dataProvider,
			'viewMode' => $viewMode,
		];

		if (Yii::app()->request->isAjaxRequest) {
			$filterStore = [
				'statuses' => $filter['statuses'],
				'dt_range' => $dtRange,
			];
			setcookie('chd_transfer_filter', serialize($filterStore), time() + 3600 * 24 * 30, Yii::app()->request->baseUrl);
			$this->renderPartial('_index_data', $viewParams);
		}
		else {
			$this->render('index', $viewParams);
		}
	}

	/**
	 * @return string
	 */
	protected function getViewMode() {
		$modes = ['table'];
		$cookie = Yii::app()->request->cookies['chd_requests_mode'];
		if (!$cookie || !in_array($cookie->value, $modes)) {
			$mode = 'list';
		}
		else {
			$mode = $cookie->value;
		}
		return $mode;
	}

	public function actionOnlysql($id) {
		$request = Yii::app()->request;
		$model = $this->loadModel($id);

		if ($request->isAjaxRequest && $request->isPostRequest) {
			$transferConfig = $request->getPost('tconfig');
			try {
				$result = [];
				$createCharForm = new CreateCharForm($model);
				$result['sql'] = $createCharForm
					->setTransferConfig($transferConfig)
					->getSql();

			} catch (Exception $ex) {
				$result['error'] = $ex->getMessage();
			}

			header('Content-Type: application/json; charset utf-8');
			echo json_encode($result);
			Yii::app()->end();
		}
	}

	public function actionChar($id) {
		$this->layout = '//layouts/column1';
		$request = Yii::app()->request;

		$model = $this->loadModel($id);

		$result = CreateCharForm::getDefaultResult();
		if ($request->isAjaxRequest && $request->isPostRequest) {
			$transferConfig = $request->getPost('tconfig');
			$createCharForm = new CreateCharForm($model);
			$result = $createCharForm
				->setTransferConfig($transferConfig)
				->createChar();
			header('Content-Type: application/json; charset utf-8');
			echo json_encode($result);
			Yii::app()->end();
		}

		$service = new WowtransferUI();

		$this->render('char', [
			'model'           => $model,
			'errors'          => $result['errors'],
			'warnings'        => $result['warnings'],
			'sql'             => $result['sql'],
			'queries'         => $result['queries'],
			'queriesCount'    => count($result['queries']),
			'tconfigs'        => $service->getTransferConfigsPair(),
		]);
	}

	public function actionDeletechar($id)
	{
		$result = ['success' => false];

		$model = $this->loadModel($id);
		try {
			$model->deleteChar();

			$result['message'] = Yii::t('app', 'Character GUID = {n} has deleted successful', $model->char_guid);
			$result['success'] = true;
		}
		catch (CharacterDeletionException $ex) {
			$result['error'] = Yii::t('app', 'Couldn`t delete the character') . ': ' . $ex->getMessage();
		} catch (Exception $ex) {
			$result['error'] = $ex->getMessage();
		}

		if (Yii::app()->request->isAjaxRequest) {
			echo json_encode($result);
			Yii::app()->end();
		}

		$redirUrl = Yii::app()->request->urlReferrer;
		$this->redirect($redirUrl);
	}

	public function actionClearCharData($id) {

	}

	/**
	 * Load lua-dump
	 *
	 * @param $id integer Transfer's ID
	 */
	public function actionLuadump($id)
	{
		$this->layout = '//layouts/column1';
		$model = $this->loadModel($id); // TODO: load only lua-dump

		if (Yii::app()->request->isAjaxRequest)
		{
			echo strip_tags($model->luaDumpFromDb());
			Yii::app()->end();
		}

		$this->render('luadump', [
			'model' => $model,
			'luaDumpContentZip' => $model->file_lua,
			'luaDumpContent' => $model->luaDumpFromDb(),
		]);
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ChdTransfer the loaded model
	 * @throws CHttpException
	 */
	protected function loadModel($id)
	{
		$model = ChdTransfer::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		$model->transferOptions = explode(';', $model->options);

		return $model;
	}

	public function actionRemotePassword($id) {
		$model = $this->loadModel($id);
		if (Yii::app()->request->isAjaxRequest) {
			echo $model->pass;
		}
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

	public function actionChangeview($mode) {
		$cookie = new CHttpCookie('chd_requests_mode', $mode);
		$cookie->path = '/chdphp';
		$cookie->expire = time() + 3600 * 30;
		Yii::app()->request->cookies['chd_requests_mode'] = $cookie;
		$this->redirect('index');
	}
}
