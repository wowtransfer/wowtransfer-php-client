<?php
/* @var $this BackendController */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->hostInfo . Yii::app()->request->baseUrl; ?>/images/favicon-admin.ico" type="image/x-icon">

	<?php $this->registerCssAndJs(); ?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="login">
			<? Yii::t('app', 'Welcome') ?> <b><?php echo Yii::app()->user->name; ?></b>
			<? $this->renderFile(Yii::getPathOfAlias('common-views') . '/layouts/change_lang.php') ?>
			<a href="<?php echo $this->createUrl('/site/logout') ?>" title="Logout">
				<span class="glyphicon glyphicon-log-out"></span> <?= Yii::t('app', 'Logout') ?>
			</a>
		</div>
	</div><!-- header -->

	<?php $this->widget('bootstrap.widgets.TbNav', array(
		'type' => 'tabs',
		'items' => [
			['label' => Yii::t('app', 'Site'), 'url'=>Yii::app()->params['siteUrl'], 'icon' => 'home'],
			array('label'=>'Главная', 'url'=>array('/'), 'active' => $this->route == 'site/index'),
			array('label' => Yii::t('app', 'Requests'), 'url'=>array('/transfers'), 'visible' => !Yii::app()->user->isGuest, 'active' => $this->id == 'transfers', 'icon' => 'list'),
			['label' => Yii::t('app', 'Configurations'), 'url' => ['/tconfigs/index'], 'icon' => 'asterisk'],
			['label' => Yii::t('app', 'Settings'), 'url' => ['/configs'], 'icon' => 'cog', 'active' => $this->id == 'configs'],
			['label' => Yii::t('app', 'Update'), 'url'=>array('/updates'), 'icon' => 'ok-circle', 'active' => $this->id == 'updates'],
		],
	)); ?><!-- mainmenu -->

	<!-- Admin / Application switch -->
	<a href="<?php echo Yii::app()->request->baseUrl . '/index.php/transfers/index'; ?>"
	   class="right" id="admin-switch" title="<?= Yii::t('app', 'Application') ?>">
		<span class="glyphicon glyphicon-arrow-left"></span>
		<?= Yii::t('app', 'Application') ?>
	</a>

	<?php if (isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumb', array(
			'links' => $this->breadcrumbs,
			'homeLabel' => CHtml::link(Yii::t('app', 'Administration'), Yii::app()->homeUrl),
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

</div><!-- page -->


<div class="container">
	<div class="navbar" id="footer">
		<div class="pull-left" style="height: 3em;">
			<?php if (!empty(Yii::app()->params['serviceUsername'])): ?>
				Service username: <strong><a href="http://wowtransfer.com/cp/profile/"><?php echo Yii::app()->params['serviceUsername']; ?></a></strong>
			<?php endif ?>
		</div>
		<div>
			Copyright &copy; 2014-2015 <a href="http://wowtransfer.com" title="wowtransfer.com">wowtransfer.com</a><br>
			All Rights Reserved.
		</div>
	</div>
</div>

</body>
</html>
