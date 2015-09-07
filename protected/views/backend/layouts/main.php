<?
/* @var $this BackendController */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="<?= Yii::app()->request->hostInfo . Yii::app()->request->baseUrl; ?>/images/favicon-admin.ico" type="image/x-icon">

	<? $this->registerCssAndJs(); ?>

	<title><?= CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="login">
			<? Yii::t('app', 'Welcome') ?> <b><?= Yii::app()->user->name; ?></b>
			<? $this->renderFile(Yii::getPathOfAlias('common-views') . '/layouts/change_lang.php') ?>
			<a href="<?= $this->createUrl('/site/logout') ?>" title="Logout">
				<span class="glyphicon glyphicon-log-out"></span> <?= Yii::t('app', 'Logout') ?>
			</a>
		</div>
	</div><!-- header -->

	<? $this->widget('bootstrap.widgets.TbNav', [
		'type' => 'tabs',
		'items' => [
			['label' => Yii::t('app', 'Site'), 'url'=>Yii::app()->params['siteUrl'], 'icon' => 'home'],
			['label' => Yii::t('zii', 'Home'), 'url'=>['/'], 'active' => $this->route == 'site/index'],
			['label' => Yii::t('app', 'Requests'), 'url'=>['/transfers'], 'visible' => !Yii::app()->user->isGuest, 'active' => $this->id == 'transfers', 'icon' => 'list'],
			['label' => Yii::t('app', 'Configurations'), 'url' => ['/tconfigs/index'], 'icon' => 'asterisk'],
			['label' => Yii::t('app', 'Settings'), 'url' => ['/configs'], 'icon' => 'cog', 'active' => $this->id == 'configs'],
			['label' => Yii::t('app', 'Update'), 'url' => ['/updates'], 'icon' => 'ok-circle', 'active' => $this->id == 'updates'],
		],
	]); ?><!-- mainmenu -->

	<!-- Admin / Application switch -->
	<a href="<?= Yii::app()->request->baseUrl . '/index.php/transfers/index'; ?>"
	   id="admin-switch" title="<?= Yii::t('app', 'Application') ?>">
		<span class="glyphicon glyphicon-arrow-left"></span>
		<?= Yii::t('app', 'Application') ?>
	</a>

	<? if (isset($this->breadcrumbs)):?>
		<? $this->widget('bootstrap.widgets.TbBreadcrumb', array(
			'links' => $this->breadcrumbs,
			'homeLabel' => CHtml::link(Yii::t('app', 'Administration'), Yii::app()->homeUrl),
		)); ?><!-- breadcrumbs -->
	<? endif?>

	<? if ($this->route !== 'configs/service' && $this->isEmptyServiceParams()): ?>
		<div class="alert alert-danger">
			<?= Yii::t('app', 'Service parameters not set up') ?>,
			<?= CHtml::link(Yii::t('app', 'Set up'), $this->createUrl('/configs/service'), ['class' => 'lowercase']) ?>.
		</div>
	<? endif ?>

	<?= $content; ?>

	<div class="clear"></div>

</div><!-- page -->


<div class="container">
	<div class="navbar" id="footer">
		<div class="pull-left" style="height: 3em;">
			<? if (!empty(Yii::app()->params['serviceUsername'])): ?>
				Service username: <strong><a href="http://wowtransfer.com/cp/profile/"><?= Yii::app()->params['serviceUsername']; ?></a></strong>
			<? endif ?>
		</div>
		<div>
			Copyright &copy; 2014-2015 <a href="http://wowtransfer.com" title="wowtransfer.com">wowtransfer.com</a><br>
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

<? $this->renderFile(Yii::getPathOfAlias('application.views.common.blocks') . '/main_dialogs.php') ?>

</body>
</html>
