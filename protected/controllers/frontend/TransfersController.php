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
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','delete'),
				'users'=>array('@'),
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
		//$this->performAjaxValidation($model);

		if (isset($_POST['ChdTransfer']))
		{
			$model->attributes = $_POST['ChdTransfer'];
			$model->fileLua = CUploadedFile::getInstance($model, 'fileLua');
			//CVarDumper::dump($_POST['ChdTransfer'], 10, true);
			if ($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
		else
		{
			if (empty($model->transferOptions))
			{
				$model->transferOptions = array_keys(Wowtransfer::getTransferOptions());
				$model->options = implode(';', $model->transferOptions);
			}
		}

		if (defined('YII_DEBUG'))
		{
			$model->server = 'server';
			$model->realmlist = 'realmlist';
			$model->realm = 'realm';
			$model->account = 'account';
			$model->pass = 'password';
			$model->pass2 = 'password';
		}
		
		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$model->setScenario('update');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['ChdTransfer']))
		{
			$model->attributes = $_POST['ChdTransfer'];
			//CVarDumper::dump($model->attributes, 10, true);
			//return;

			if ($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('ChdTransfer', array(
			'criteria' => array(
				'condition' => 'account_id=' . Yii::app()->user->id,
			),
		));

		$this->render('index',array(
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
		$model = ChdTransfer::model()->findByPk($id);
		if ($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		if ($model->account_id != Yii::app()->user->id)
			throw new CHttpException(403,'Error. Unknown transfer id.');
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='chd-transfer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
