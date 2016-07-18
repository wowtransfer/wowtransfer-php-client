<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Error');
$this->breadcrumbs = [
	Yii::t('app', 'Error'),
];
?>

<h2><?= Yii::t('app', 'Error') ?> <?= $code; ?></h2>

<div class="error">
    <?= CHtml::encode($message); ?>
</div>
