<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->hostInfo . Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon">

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/common.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/form.css">

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/frontend.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

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

	<?php $this->widget('booster.widgets.TbMenu',array(
		'type' => 'tabs',
		'items' => array(
			array('label' => 'Сайт', 'url' => Yii::app()->params['siteUrl'], 'icon' => 'home'),
			array('label' => 'Заявки', 'url' => array('/transfers'), 'icon' => 'list', 'visible' => !Yii::app()->user->isGuest, 'active' => $this->id == 'transfers'),
			array('label' => 'Помощь', 'url' => array('/site/page'), 'icon' => 'info-sign'),
		),
	)); ?><!-- mainmenu -->

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

	<?php if (isset($this->breadcrumbs)): ?>
		<?php $this->widget('booster.widgets.TbBreadcrumbs', array(
			'links' => $this->breadcrumbs,
			'homeLink' => false,
		)); ?><!-- breadcrumbs -->
	<?php endif; ?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> <a href="http://wowtransfer.com" title="wowtransfer.com">wowtransfer.com</a><br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
