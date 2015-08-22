<?php

class UpdatesController extends BackEndController
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

	public function actionLatestRelease() {
		Yii::import('application.components.Github');
		$github = new \Github();
		$release = $github->getLatestRelease();
		$result = [];
		if ($release) {
			// "tag_name": "v1.0.0",
			// "created_at": "2013-02-27T19:35:32Z",
			// "assets":
			//   'browser_download_url' => 'https://github.com/wowtransfer/chdphp/releases/download/v1.1/chdphp-v1.1.zip'
			//   'name' => 'chdphp-v1.1.zip'
			// 'zipball_url' => 'https://api.github.com/repos/wowtransfer/chdphp/zipball/v1.1'
			$result['tag_name'] = $release->tag_name;
			$result['created_at'] = $release->created_at;
			if (isset($release->assets)) {
				$asset = $release->assets[0];
				$result['download_url'] = $asset->browser_download_url;
				$result['name'] = $asset->name;
			}
		}
		echo CJSON::encode($result);
	}
}