<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->hostInfo . Yii::app()->request->baseUrl; ?>/images/favicon-admin.ico" type="image/x-icon">

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/common.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/form.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/backend.css" />
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/backend.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="login">
			<div>Добро пожаловать <b><?php echo Yii::app()->user->name; ?></b></div>
			<a href="<?php echo $this->createUrl('/site/logout') ?>" title="Logout"><span class="glyphicon glyphicon-log-out"></span> Выйти</a>
		</div>
	</div><!-- header -->

	<?php $this->widget('booster.widgets.TbMenu', array(
		'type' => 'tabs',
		'items' => array(
			array('label'=>'Сайт', 'url'=>Yii::app()->params['siteUrl'], 'icon' => 'home'),
			array('label'=>'Главная', 'url'=>array('/'), 'active' => $this->route == 'site/index'),
			array('label'=>'Заявки', 'url'=>array('/transfers/index'), 'visible' => !Yii::app()->user->isGuest, 'active' => $this->id == 'transfers', 'icon' => 'list'),
			array('label'=>'Конфигурации', 'url'=>array('/tconfigs/index'), 'icon' => 'asterisk'),
			array('label'=>'Настройка', 'url'=>array('/configs/index'), 'icon' => 'cog', 'active' => $this->id == 'configs'),
			array('label'=>'Карта', 'url'=>array('/site/sitemap'), 'icon' => 'map-marker'),
		),
	)); ?><!-- mainmenu -->

	<!-- Admin / Application switch -->
	<?php $this->widget('booster.widgets.TbButton', array(
		'context' => 'link',
		'buttonType' => 'link',
		'url' => Yii::app()->request->baseUrl . '/index.php/transfers/index',
		'label' => 'Приложение',
		'icon' => 'arrow-left',
		'htmlOptions' => array('class' => 'right', 'id' => 'admin-switch', 'title' => 'Приложение'),
	))?>

	<?php if (isset($this->breadcrumbs)):?>
		<?php $this->widget('booster.widgets.TbBreadcrumbs', array(
			'links' => $this->breadcrumbs,
			'homeLink' => CHtml::link('Админка', Yii::app()->homeUrl),
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

</div><!-- page -->


<div class="container">
<div class="navbar">
	<div class="navbar-fixed-bottom navbar-default">
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> <a href="http://wowtransfer.com" title="wowtransfer.com">wowtransfer.com</a><br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->
	</div>
</div>
</div>

<script>chdInit("<?php echo Yii::app()->homeUrl; ?>");</script>

</body>
</html>
