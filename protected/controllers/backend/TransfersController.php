<?php

class TransfersController extends BackendController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','index','view','update','delete','char','createchar','deletechar','luadump'),
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
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['ChdTransfer']))
		{
			$model->attributes = $_POST['ChdTransfer'];
			if ($model->save())
				$this->redirect(array('view','id' => $model->id));
		}

		$this->render('update', array(
			'model'=>$model,
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

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		/*$command = Yii::app()->db->createCommand();
		$command = $command->select('id, account_id, server, realmlist, realm, username_old, username_new, char_guid, create_char_date, create_transfer_date, status, account, pass, options, comment')
			->from('chd_transfer t')
			->leftJoin('account a', 't.account_id=a.id');
			//->where('');*/
		$dataProvider = new CActiveDataProvider('ChdTransfer');

		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ChdTransfer('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ChdTransfer']))
			$model->attributes=$_GET['ChdTransfer'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionCharinfo($id)
	{
		$model = null;

		$this->render('charinfo', array(
			'model' => $model,
		));
	}

	public function actionChar($id)
	{
		$this->layout = '//layouts/column1';

		$model = $this->loadModel($id);
		if ($model->char_guid > 0)
			throw new CHttpException(403, 'Character created! GUID = ' . $model->char_guid);

		$result = array(
			'error'   => '',
			'sql'     => '',
			'queries' => array(),
		);
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
			'error'           => $result['error'],
			'sql'             => $result['sql'],
			'queries'         => $result['queries'],
			'queriesCount'    => count($result['queries']),
			'tconfigs'        => $tconfigs,
		));
	}

	public function actionCreatechar($id)
	{
		$model = $this->loadModel($id);

		$this->render('createchar', array(
			'model' => $model,
		));
	}

	public function actionDeletechar($id)
	{
		$model = $this->loadModel($id);
		$result = $model->deleteChar();

		if (Yii::app()->request->isAjaxRequest)
		{
			echo $result;
			Yii::app()->exit();
		}

		if ($result)
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
