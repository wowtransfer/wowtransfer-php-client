<?
/* @var $this SiteCOntroller */

?>

<h1><?= Yii::t('yii', 'Login Required') ?></h1>

<p>
	<?= Yii::t('app', 'Welcome') ?> <?= Yii::app()->user->guestName; ?>,
	<a href="<?= $this->createUrl('login'); ?>">
		<?= Yii::t('app', 'Authorize for transfer request handle') ?></a>.
</p>