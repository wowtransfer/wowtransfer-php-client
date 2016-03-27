<?php

class CharactersController extends BackEndController
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
		$transferTable = Config::getInstance()->getTransferTable();
		$command = Yii::app()->db->createCommand();
		$command
			->select('guid, c.account, name, race, class, gender, level, arenaPoints, totalHonorPoints, totalKills')
			->from('characters c')
			->join($transferTable . ' ct', 'ct.char_guid = c.guid')
			->queryAll();

		$sqlCount = 'SELECT COUNT(*) FROM (' . $command->text . ') as count_alias';
		$count = Yii::app()->db->createCommand($sqlCount)->queryScalar();

		$dataProvider = new CSqlDataProvider($command->text, [
			'keyField' => 'guid',
			'totalItemCount' => $count,
		]);

		$this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionDelete($id) {

	}

	public function clearById($id) {

	}

	public function clearByGuid() {
		if (!Config::getInstance()->getYiiDebug()) {
			return false;
		}
	}
}