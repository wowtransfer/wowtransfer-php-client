<?
/* @var $this BackendController */
/* @var $dataProvider CActiveDataProvider */
/* @var $viewMode string */

$this->widget('zii.widgets.CListView', array(
	'id' => 'transfers-listview',
	'dataProvider' => $dataProvider,
	'itemView' => '_view_' . $viewMode,
));
