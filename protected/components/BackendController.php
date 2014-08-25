<?php

class BackendController extends BaseController
{
	public $layout = '//layouts/column1';

	/**
	 * FIlters
	 */
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	/**
	 * 
	 */
	public function accessRules()
	{
		return array(
			// only admin
			array(
				'allow',
				'roles'=>array('admin'),
			),
			// login.php allow view
			array(
				'allow',
				'actions'=>array('login'),
				'users'=>array('?'),
			),
			array(
				'allow',
				'actions'=>array('error'),
				'users'=>array('*'),
			),
			// deny from all
			array(
				'deny',
				'users'=>array('*'),
			), 
		);
	}

	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error)
		{
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
			{
				if (Yii::app()->user->isAdmin())
					$this->render('error', $error);
				else
					echo 'hi';
			}
		}
	}
}