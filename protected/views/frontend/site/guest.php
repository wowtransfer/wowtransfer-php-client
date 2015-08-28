<?php
/* @var $this SiteCOntroller */

?>

<h1><?= Yii::t('yii', 'Login Required') ?></h1>

<p>
	<?= Yii::t('app', 'Wellcome') ?> <?php echo Yii::app()->user->guestName; ?>,
	<a href="<?php echo $this->createUrl('login'); ?>">
		<?= Yii::t('app', 'Authorize for transfer request handle') ?></a>.
</p>