<?
/* @var $this FrontEndController */
?>
<!DOCTYPE html>
<html lang="<?= Yii::app()->language ?>">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="<?= Yii::app()->request->hostInfo . Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon">

	<? $this->registerCssAndJs(); ?>

	<title><?= CHtml::encode($this->pageTitle); ?></title>

	<script>
		window.config = [];
		window.config.homeUrl = "<?= Yii::app()->homeUrl; ?>";
	</script>
</head>

<body>

<div class="container" id="page">

	<div class="row">
		<div class="col-md-12">
			<div id="header">
				<div id="login">
					<? if (Yii::app()->user->isGuest): ?>
						<? $this->renderFile(Yii::getPathOfAlias('common-views') . '/layouts/change_lang.php') ?>
						<? if ($this->route != 'site/login'): ?>
							<a href="<?= $this->createUrl('/site/login'); ?>">
								<span class="glyphicon glyphicon-log-in"></span>
								<?= Yii::t('app', 'Login') ?>
							</a>
						<? endif; ?>
					<? else: ?>
						<div><?= Yii::t('app', 'Welcome') ?> <b><?= Yii::app()->user->name; ?></b></div>
						<? $this->renderFile(Yii::getPathOfAlias('common-views') . '/layouts/change_lang.php') ?>
						<a href="<?= Yii::app()->createUrl('site/logout') ?>">
							<span class="glyphicon glyphicon-log-out"></span>
							<?= Yii::t('app', 'Logout') ?>
						</a>
					<? endif; ?>
				</div>
				<div id="logo">
					<img alt="" src="<?= Yii::app()->request->baseUrl; ?>/images/wowtransfer-icon-48.png" title="wowtransfer icon">
					<?= Yii::t('app', 'Characters transfer') ?>
				</div>
			</div><!-- header -->
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<? $this->widget('bootstrap.widgets.TbNav',array(
				'type' => 'tabs',
				'items' => $this->getMenu(),
			)); ?><!-- mainmenu -->
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<!-- Admin / Application switch -->
			<? if (Yii::app()->user->isAdmin()): ?>
			<a href="<?= Yii::app()->request->baseUrl . '/admin.php/transfers/index'; ?>"
			   id="admin-switch">
				<span class="glyphicon glyphicon-cog"></span>
				<?= Yii::t('app', 'Administration') ?>
			</a>
			<? endif; ?>

			<? if (!empty($this->breadcrumbs)): ?>
				<? $this->widget('bootstrap.widgets.TbBreadcrumb', array(
					'links' => $this->breadcrumbs,
					'homeLabel' => Yii::t('app', 'Characters transfer'),
				)); ?><!-- breadcrumbs -->
			<? endif; ?>
		</div>
	</div>

	<div class="row">
		<?= $content; ?>
	</div>

	<div class="clearfix"></div>

</div><!-- page -->

<div class="container">
	<div class="col-md-12">
		<footer id="footer">
			Copyright &copy; 2014-2015 <a href="http://wowtransfer.com" title="wowtransfer.com">wowtransfer.com</a><br>
			All Rights Reserved.
		</footer>
	</div>
</div>

<? $this->renderFile(Yii::getPathOfAlias('application.views.common.blocks') . '/main_dialogs.php') ?>

</body>
</html>
