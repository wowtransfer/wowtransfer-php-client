<?php
/* @var $this ConfigsController */

$this->breadcrumbs = array(
	'Настройка',
);
?>

<ul>
	<li>
		<a href="<?php echo $this->createUrl('/configs/app'); ?>">
			<?= Yii::t('app', 'Application') ?>
		</a>
	</li>
	<li><a href="<?php echo $this->createUrl('/configs/service'); ?>">Связь с сервисом</a></li>
	<li><a href="<?php echo $this->createUrl('/configs/toptions'); ?>"><?= Yii::t('app', 'Transfer options') ?></a></li>
	<li>
		<a href="<?php echo $this->createUrl('/configs/remoteservers'); ?>">Удаленные сервера</a>
		<span class="label label-warning">todo</span>
	</li>
</ul>