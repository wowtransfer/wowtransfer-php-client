<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->hostInfo . Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon">

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
			<div>Добро пожаловать <b><?php echo Yii::app()->user->name; ?></b><br></div>
			<a href="<?php echo $this->createUrl('/site/logout') ?>" title="Logout">Выйти</a>
		</div>
		<div id="logo">Админка</div>
	</div><!-- header -->

	<?php $this->widget('booster.widgets.TbMenu', array(
		'type' => 'tabs',
		'items' => array(
			array('label'=>'Сайт', 'url'=>Yii::app()->params['siteUrl']),
			array('label'=>'Заявки', 'url'=>array('/transfers/index'), 'visible' => !Yii::app()->user->isGuest),
			array('label'=>'Конфигурации', 'url'=>array('/tconfigs/index')),
			array('label'=>'Настройка', 'url'=>array('/configs/index')),
			array('label'=>'Карта', 'url'=>array('/site/sitemap')),
		),
	)); ?><!-- mainmenu -->

	<!-- Admin / Application switch -->
	<?php if (Yii::app()->user->isAdmin()): ?>
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'link',
			'url' => Yii::app()->request->baseUrl . '/index.php/transfers/index',
			'label' => 'Приложение',
			'icon' => 'arrow-left',
			'htmlOptions' => array('class' => 'right', 'id' => 'admin-switch'),
		))?>
	<?php endif; ?>

	<?php if (isset($this->breadcrumbs)):?>
		<?php $this->widget('booster.widgets.TbBreadcrumbs', array(
			'links' => $this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> <a href="http://wowtransfer.com" title="wowtransfer.com">wowtransfer.com</a><br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
