<?php
/* @var $this FrontEndController */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->hostInfo . Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon">

	<?php $this->registerCssAndJs(); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<script>
		window.config = [];
		window.config.homeUrl = "<?php echo Yii::app()->homeUrl; ?>";
	</script>
</head>

<body>

<div class="container" id="page">

	<div class="row">
	<div class="col-md-12">
		<!-- TODO: make widget -->
		<div id="header">
			<div id="login">
				<?php if (Yii::app()->user->isGuest): ?>
					<? $this->renderFile(Yii::getPathOfAlias('common-views') . '/layouts/change_lang.php') ?>
					<?php if ($this->route != 'site/login'): ?>
						<a href="<?php echo $this->createUrl('/site/login'); ?>">
							<span class="glyphicon glyphicon-log-in"></span>
							<?= Yii::t('app', 'Login') ?>
						</a>
					<?php endif; ?>
				<?php else: ?>
					<div><?= Yii::t('app', 'Welcome') ?> <b><?php echo Yii::app()->user->name; ?></b></div>
					<? $this->renderFile(Yii::getPathOfAlias('common-views') . '/layouts/change_lang.php') ?>
					<a href="<?php echo Yii::app()->createUrl('site/logout') ?>">
						<span class="glyphicon glyphicon-log-out"></span>
						<?= Yii::t('app', 'Logout') ?>
					</a>
				<?php endif; ?>
			</div>
			<div id="logo">
				<img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/images/wowtransfer-icon-48.png" title="wowtransfer icon">
				<?= Yii::t('app', 'Characters transfer') ?>
			</div>
		</div><!-- header -->
	</div>
	</div>

	<div class="row">
	<div class="col-md-12">
		<?php $this->widget('bootstrap.widgets.TbNav',array(
			'type' => 'tabs',
			'items' => $this->getMenu(),
		)); ?><!-- mainmenu -->
	</div>
	</div>

	<div class="row">
	<div class="col-md-12">
		<!-- Admin / Application switch -->
		<?php if (Yii::app()->user->isAdmin()): ?>
		<a href="<?php echo Yii::app()->request->baseUrl . '/admin.php/transfers/index'; ?>"
		   id="admin-switch">
			<span class="glyphicon glyphicon-cog"></span>
			<?= Yii::t('app', 'Administration') ?>
		</a>
		<?php endif; ?>

		<?php if (!empty($this->breadcrumbs)): ?>
			<?php $this->widget('bootstrap.widgets.TbBreadcrumb', array(
				'links' => $this->breadcrumbs,
				'homeLabel' => Yii::t('app', 'Characters transfer'),
			)); ?><!-- breadcrumbs -->
		<?php endif; ?>
	</div>
	</div>

	<div class="row">
		<?php echo $content; ?>
	</div>

	<div class="clearfix"></div>

</div><!-- page -->

<div class="container">
	<div class="col-md-12">
		<footer id="footer">
			<div class="navbar">
				Copyright &copy; 2014-2015 <a href="http://wowtransfer.com" title="wowtransfer.com">wowtransfer.com</a><br/>
				All Rights Reserved.<br/>
			</div>
		</footer>
	</div>
</div>

<div class="modal fade" id="chd-modal-info">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title"><?php echo Yii::app()->name; ?></h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<? $this->renderFile(Yii::getPathOfAlias('application.views.common.blocks') . '/main_dialogs.php') ?>

</body>
</html>
