<?php
/* @var BackendController $this */
/* @var CActiveDataProvider $dataProvider */

$this->widget('zii.widgets.CListView', array(
	'id' => 'transfers-listview',
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
));
