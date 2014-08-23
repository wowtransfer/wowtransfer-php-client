<?php
/* @var $this SiteCOntroller */

?>

<h1>Необходима авторизация</h1>

<p>Добро пожаловать <?php echo Yii::app()->user->guestName; ?>, <a href="<?php echo $this->createUrl('login'); ?>">авторизуйтесь</a> для управления заявками.</p>