<?php
/* @var BackendController $this */
/* @var array $tconfig */

$this->breadcrumbs = array(
	'Конфигурации переноса' => array('/tconfigs'),
	$tconfig['name'],
);
?>

<h1>Конфигурация #<?php echo $tconfig['id'] ?></h1>

<?php $this->renderPartial('_form', array('tconfig' => $tconfig)); ?>