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

<? $this->widget('bootstrap.widgets.TbNavbar', [
	'brandLabel' => TbHtml::tag('img', [
		'alt' => '',
		'src' => Yii::app()->request->baseUrl . '/images/wowtransfer-icon-24.png',
	]),
	'brandUrl' => $this->createUrl('/'),
	'collapse' => false,
	'items' => [
		[
			'class' => 'bootstrap.widgets.TbNav',
			'items' => $this->getMainMenuItems(),
		],
		[
			'class' => 'bootstrap.widgets.TbNav',
			'htmlOptions' => ['class' => 'navbar-right'],
			'encodeLabel' => false,
			'items' => $this->getRightMenuItems(),
		]
	],
]) ?>

<div class="container" id="page">

	<div class="row">
		<div class="col-md-12">
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
