<?php
/* @var $this CharactersController */
/* @var $dataProvider CSqlDataProvider */

$this->breadcrumbs = [
	Yii::t('app', 'Characters'),
];
?>
<h1><?= Yii::t('app', 'Characters') ?></h1>

<div>
	<?php $this->widget('zii.widgets.grid.CGridView', [
		'id' => 'characters-grid',
		'dataProvider' => $dataProvider,
		'columns' => [
			'guid',
			'c.account',
			'name',
			'race',
			'class',
			'level',
			'arenaPoints',
			'totalHonorPoints',
			'totalKills',
			[
				'class' => 'CButtonColumn',
				'template' => '{delete}, {clearById}, {clearByGuid}',
				'buttons' => [
					'delete' => [
						'url' => 'Yii::app()->createUrl("delete", ["id" => $data["guid"]])',
					],
					'clearById' => [
						'url' => '',
					],
					'clearByGuid' => [
						'url' => '',
					],
				],
			]
		]
	]) ?>
</div>