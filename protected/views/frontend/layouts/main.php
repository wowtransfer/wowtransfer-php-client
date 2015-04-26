<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->hostInfo . Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon">

	<?php
	$cs = Yii::app()->clientScript;
	$cs->registerCssFile(Yii::app()->baseUrl . '/css/main.css');
	$cs->registerCssFile(Yii::app()->baseUrl . '/css/form.css');
	$cs->registerCssFile(Yii::app()->baseUrl . '/css/common.css');
	$cs->registerCssFile(Yii::app()->baseUrl . '/css/frontend.css');

	$cs->registerScriptFile(Yii::app()->baseUrl . '/js/common.js', CClientScript::POS_END);
	$cs->registerScriptFile(Yii::app()->baseUrl . '/js/frontend.js', CClientScript::POS_END);
	?>

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
					<?php if ($this->route != 'site/login'): ?>
						<?php $this->widget('booster.widgets.TbButton', array(
							'context' => 'link',
							'buttonType' => 'link',
							'url' => $this->createUrl('/site/login'),
							'label' => 'Войти',
							'icon' => 'log-in',
						)); ?>
						<?php endif; ?>
				<?php else: ?>
					<div>Добро пожаловать <b><?php echo Yii::app()->user->name; ?></b></div>
					<a href="<?php echo Yii::app()->createUrl('site/logout') ?>" title="Logout"><span class="glyphicon glyphicon-log-out"></span> Выйти</a>
				<?php endif; ?>
			</div>
			<div id="logo">
				<img alt="" src="<?php echo Yii::app()->baseUrl; ?>/images/wowtransfer-icon-48.png" title="wowtransfer icon">
				<?php echo CHtml::encode(Yii::app()->name); ?>
			</div>
		</div><!-- header -->
	</div>
	</div>

	<div class="row">
	<div class="col-md-12">
		<?php $this->widget('booster.widgets.TbMenu',array(
			'type' => 'tabs',
			'items' => $this->getMenu(),
		)); ?><!-- mainmenu -->
	</div>
	</div>

	<div class="row">
	<div class="col-md-12">
		<!-- Admin / Application switch -->
		<?php if (Yii::app()->user->isAdmin()): ?>
			<?php $this->widget('booster.widgets.TbButton', array(
				'context' => 'link',
				'buttonType' => 'link',
				'label' => 'Администрирование',
				'url' => Yii::app()->request->baseUrl . '/admin.php/transfers/index',
				'icon' => 'cog',
				'htmlOptions' => array('class' => 'right', 'id' => 'admin-switch'),
			))?>
		<?php endif; ?>

		<?php if (!empty($this->breadcrumbs)): ?>
			<?php $this->widget('booster.widgets.TbBreadcrumbs', array(
				'links' => $this->breadcrumbs,
				'homeLink' => false,
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
<div class="navbar" id="footer">
		Copyright &copy; <?php echo date('Y'); ?> <a href="http://wowtransfer.com" title="wowtransfer.com">wowtransfer.com</a><br/>
		All Rights Reserved.<br/>
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
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>
