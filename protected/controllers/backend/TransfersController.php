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
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','index','view','update','delete','char','deletechar','luadump','filter'),
				'roles'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$model->options = str_replace(';', ', ', $model->options);

		$this->render('view', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (Yii::app()->request->isAjaxRequest && !empty($_POST))
		{
			$model = $this->loadModel($id);
			$model->setScenario('update');
			$model->attributes = $_POST;
			if (!$model->save(true, array_keys($_POST)))
				throw new CHttpException(501, 'Error');
			Yii::app()->end();
		}
		$this->redirect(array('index'));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dtRange = 30;
		$statuses = array();
		$filter = array();

		if (Yii::app()->request->isAjaxRequest)
		{
			$filter = $_POST;
		}
		else
		{
			if (isset($_COOKIE['chd_transfer_filter']))
				$filter = unserialize($_COOKIE['chd_transfer_filter']);
		}

		$statuses = isset($filter['statuses']) ? $filter['statuses'] : $statuses;
		$dtRange = isset($filter['dt_range']) ? (int)$filter['dt_range'] : $dtRange;
		if ($statuses)
		{
			$statusesOrigin = ChdTransfer::getStatuses();
			if (count($statusesOrigin) === count($statuses))
			{
				$statuses = array();
				$filter['statuses'] = $statuses;
			}
		}
		$this->filterStatuses = $statuses;
		$this->filterDtRange = $dtRange;

		$where = "`create_transfer_date` > '" . date('Y-m-d', strtotime("-$dtRange days")) . "'";
		if (!empty($statuses)) {
			for ($i = 0; $i < count($statuses); ++$i)
				$statuses[$i] = "'" . $statuses[$i] . "'";
			$where .= " AND `status` IN (" . implode(',', $statuses) . ")";
		}

		$dataProvider = new CActiveDataProvider('ChdTransfer', array(
			'criteria' => array(
				'select' => '*',
				'condition' => $where,
			),
		));

		$filterBlock = $this->renderPartial('_filter_form', null, true);
		$this->addAsideBlockToColumn2($filterBlock);

		if (Yii::app()->request->isAjaxRequest)
		{
			$filterStore = array(
				'statuses' => $filter['statuses'],
				'dt_range' => $dtRange,
			);
			setcookie('chd_transfer_filter', serialize($filterStore), time() + 60 * 60 * 24 * 30, Yii::app()->request->baseUrl);

			$this->renderPartial('_index_data', array('dataProvider' => $dataProvider));
		}
		else
		{
			$this->render('index', array(
				'dataProvider' => $dataProvider,
			));
		}
	}
	
	public function actionChar($id)
	{
		$this->layout = '//layouts/column1';

		$model = $this->loadModel($id);
		if ($model->char_guid > 0)
			throw new CHttpException(403, 'Character created! GUID = ' . $model->char_guid);

		$result = CreateCharForm::getDefaultResult();
		if (isset($_POST['ChdTransfer']))
		{
			$transferConfig = isset($_POST['tconfig']) ? $_POST['tconfig'] : '';
			$createCharForm = new CreateCharForm($model);
			$result = $createCharForm->createChar($transferConfig);

			if (Yii::app()->request->isAjaxRequest)
			{
				echo json_encode($result);
				Yii::app()->end();
			}
		}

		$service = new WowtransferUI;
		$service->setAccessToken(Yii::app()->params['accessToken']);
		$service->setBaseUrl(Yii::app()->params['apiBaseUrl']);
		$tconfigs = $service->getTransferConfigs();

		$this->render('char', array(
			'model'           => $model,
			'errors'          => $result['errors'],
			'warnings'        => $result['warnings'],
			'sql'             => $result['sql'],
			'queries'         => $result['queries'],
			'queriesCount'    => count($result['queries']),
			'tconfigs'        => $tconfigs,
		));
	}

	public function actionDeletechar($id)
	{
		$result = array();

		$model = $this->loadModel($id);
		try {
			if (!$model->deleteChar())
				$result['error'] = 'Не удалось удалить персонажа';
		} catch (Exception $ex) {
			$result['error'] = $ex->getMessage();
		}

		if (Yii::app()->request->isAjaxRequest)
		{
			echo json_encode($result);
			Yii::app()->end();
		}

		if (!isset($result['error']))
			$this->redirect(Yii::app()->request->ScriptUrl . '/transfers');

		$this->render('deletechar', array(
			'model' => $model,
		));
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

		$this->render('luadump', array(
			'model' => $model,
			'luaDumpContentZip' => $model->file_lua,
			'luaDumpContent' => $model->luaDumpFromDb(),
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
		$model = ChdTransfer::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		$model->transferOptions = explode(';', $model->options);

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ChdTransfer $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='chd-transfer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
