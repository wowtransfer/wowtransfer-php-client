<?
$this->widget('zii.widgets.CListView', [
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
	'ajaxUpdate' => true,
	'id' => 'transfer-list-view',
]);
