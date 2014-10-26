<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="shortcut icon" href="<?php echo Yii::app()->request->hostInfo . Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon">

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/backend.css" />
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/backend.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="login">
			<?php if (Yii::app()->user->isGuest): ?>
				<a href="<?php echo $this->createUrl('/site/login') ?>" title="Login">Войти</a>
			<?php else: ?>
				<div>Добро пожаловать <b><?php echo Yii::app()->user->name; ?></b><br></div>
				<a href="<?php echo $this->createUrl('/site/logout') ?>" title="Logout">Выйти</a>
			<?php endif; ?>
		</div>
		<div id="logo">Админка</div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Сайт','url'=>Yii::app()->params['siteUrl']),
				array('label'=>'Заявки', 'url'=>array('/transfers/index'), 'visible' => !Yii::app()->user->isGuest),
				array('label'=>'Конфигурации', 'url'=>array('/tconfigs/index')),
				array('label'=>'Настройка', 'url'=>array('/configs/index')),
				array('label'=>'Карта', 'url'=>array('/site/sitemap')),
			),
		)); ?>

	<!-- Admin / Application switch -->
	<?php if (Yii::app()->user->isAdmin()): ?>
		<?php $this->widget('booster.widgets.TbButton', array(
			'label' => 'Приложение',
			'url' => Yii::app()->request->baseUrl . '/index.php/transfers/index',
			'icon' => 'arrow-left',
			'htmlOptions' => array('class' => 'right', 'id' => 'admin-switch'),
		))?>
	<?php endif; ?>

	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> <a href="http://wowtransfer.com" title="wowtransfer.com">wowtransfer.com</a><br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
