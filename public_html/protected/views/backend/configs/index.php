<?php

/* @var $this ConfigsController */

$this->breadcrumbs = [
	Yii::t('app', 'Settings')
];
?>

<ul>
	<li>
		<a href="<?= $this->createUrl('/configs/app'); ?>">
			<?= Yii::t('app', 'Application') ?>
		</a>
	</li>
	<li>
		<a href="<?= $this->createUrl('/configs/service'); ?>">
			<?= Yii::t('app', 'Service connection') ?>
		</a>
	</li>
	<li>
		<a href="<?= $this->createUrl('/configs/db'); ?>">
			<?= Yii::t('app', 'Database') ?>
		</a>
	</li>
	<li>
		<a href="<?= $this->createUrl('/configs/toptions'); ?>">
			<?= Yii::t('app', 'Transfer options') ?>
		</a>
	</li>
	<li>
		<a href="<?= $this->createUrl('/configs/remoteservers'); ?>">
			<?= Yii::t('app', 'Remote servers') ?>
		</a>
		<span class="label label-warning">todo</span>
	</li>
</ul>
