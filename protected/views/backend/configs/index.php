<?php
/* @var $this ConfigsController */

$this->breadcrumbs = array(
	'Настройка',
);
?>

<ul>
	<li><a href="<?php echo $this->createUrl('/configs/app'); ?>">Приложение</a></li>
	<li><a href="<?php echo $this->createUrl('/configs/service'); ?>">Связь с сервисом</a></li>
	<li><a href="<?php echo $this->createUrl('/configs/toptions'); ?>">Опции переноса</a></li>
	<li><a href="<?php echo $this->createUrl('/configs/remoteservers'); ?>">Удаленные сервера</a></li>
</ul>