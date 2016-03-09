<?php

/* @var BackendController $this */
/* @var array $tconfig */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer configurations') => ['/tconfigs'],
	$tconfig['name'],
];
?>

<h1><?= Yii::t('app', 'Configuration') ?> #<?= $tconfig['id'] ?></h1>

<?php $this->renderPartial('_form', array('tconfig' => $tconfig)); ?>