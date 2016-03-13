<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Helpful information');
$this->breadcrumbs = [
    Yii::t('app', 'Helpful information'),
];
?>

<h1><?= Yii::t('app', 'Helpful information') ?></h1>

<ul>
    <li>
        <a href="http://wowtransfer.com/downloads/chardumps/">
            <?= Yii::t('app', 'Download the addon for transfer') ?>
        </a>
    </li>
    <li>
        <a href="http://wowtransfer.com/docs/service/create-dump-335a/">
            <?= Yii::t('app', 'Create the dump of character in 3.3.5a') ?>
        </a>
    </li>
    <li>
        <a href="http://wowtransfer.com/docs/service/tconfig-common/">
            <?= Yii::t('app', 'Transfer configurations') ?>
        </a>
    </li>
    <li><?= Yii::t('app', 'Request`s statuses') ?>:
        <ul>
            <li><b>process</b>: <?= Yii::t('app', 'Request was created') ?>.</li>
            <li><b>check</b>: <?= Yii::t('app', 'Request are checking by administrator') ?>.</li>
            <li><b>cancel</b>: <?= Yii::t('app', 'Request was canceled') ?>.</li>
            <li><b>apply</b>: <?= Yii::t('app', 'Request was checked and accepted, a character will created later') ?>.</li>
            <li><b>game</b>: <?= Yii::t('app', 'Request was accepted, the character was created, log in the game') ?>.</li>
        </ul>
    </li>
</ul>