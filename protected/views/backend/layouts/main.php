<?php

/* @var $this BackendController */
?>
<!DOCTYPE html>
<html lang="<?= Yii::app()->language ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="<?= Yii::app()->request->hostInfo . Yii::app()->request->baseUrl; ?>/images/favicon-admin.ico" type="image/x-icon">

	<?php $this->registerCssAndJs(); ?>

	<title><?= CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<?php $this->widget('bootstrap.widgets.TbNavbar', [
		'brandLabel' => TbHtml::tag('img', [
			'alt' => '',
			'src' => Yii::app()->request->baseUrl . '/images/wowtransfer-icon-24.png',
		]),
		'brandUrl' => $this->createUrl('/'),
		'collapse' => false,
		'items' => [
			[
				'class' => 'bootstrap.widgets.TbNav',
				'items' =>  $this->getMainMenuItems()
			],
			[
				'class' => 'bootstrap.widgets.TbNav',
				'htmlOptions' => ['class' => 'navbar-right'],
				'encodeLabel' => false,
				'items' => $this->getRightMenuItems()
			]
		],
	]) ?>

	<?php if (isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumb', array(
			'links' => $this->breadcrumbs,
			'homeLabel' => CHtml::link(Yii::t('app', 'Administration'), Yii::app()->homeUrl),
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php if ($this->route !== 'configs/service' && $this->isEmptyServiceParams()): ?>
		<div class="alert alert-danger">
			<?= Yii::t('app', 'Service parameters not set up') ?>,
			<?= CHtml::link(Yii::t('app', 'Set up'), $this->createUrl('/configs/service'), ['class' => 'lowercase']) ?>.
		</div>
	<?php endif ?>

	<?= $content; ?>

	<div class="clear"></div>

</div><!-- page -->


<div class="container">
	<div class="navbar" id="footer">
		<div class="pull-left" style="height: 3em;">
			<?php if (Config::getInstance()->getServiceUsername()): ?>
				Service username: <strong><a href="http://wowtransfer.com/cp/profile/"><?= Yii::app()->params['serviceUsername']; ?></a></strong>
			<?php endif ?>
		</div>
		<div>
			Copyright &copy; 2014-2016 <a href="http://wowtransfer.com" title="wowtransfer.com">wowtransfer.com</a><br>
			All Rights Reserved.
		</div>
	</div>
</div>

<!-- simple message dialog -->
<div class="modal fade" id="dialog" tabindex="-1" role="dialog" aria-labelledby="dialog-title">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="dialog-title"><?= Yii::t('app', 'Message') ?></h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->renderFile(Yii::getPathOfAlias('application.views.common.blocks') . '/main_dialogs.php') ?>

</body>
</html>
