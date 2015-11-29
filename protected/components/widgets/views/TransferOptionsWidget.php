<?php
/* @var $optionsGlobal array */
/*
Show transfer's options

option item has:
- name
- title
- icon (name, URL)
- large image (optionally, depends of icon's name)

*/

$options = explode(';', $model->options);
?>

<div class="well well-small toptions-block">

<?php if (!$readonly): ?>
	<div>
		<a class="btn btn-default toptions-btn set" title="<?= Yii::t('app', 'Set all') ?>">+</a>
		<a class="btn btn-default toptions-btn unset" title="<?= Yii::t('app', 'Unset all') ?>">-</a>
		<a class="btn btn-default toptions-btn invert" title="<?= Yii::t('app', 'Invert') ?>">&pm;</a>
	</div>

	<div id="transfer-options-container">
<?php
	$i = 0;
	foreach ($optionsGlobal as $name => $option) {
		$id = "ChdTransfer_transferOptions_$i";
?>
		<span class="toptions">
			<span class="tdata-icon icon-<?= $name; ?>"></span>
		<?php if (isset($option['disabled'])): ?>
			<?= CHtml::label($option['label'], $id, array('style' => 'margin-left: 18px; color: gray;')); ?>
		<?php else: ?>
			<?= CHtml::checkBox("ChdTransfer[transferOptions][]", in_array($name, $options), array('id' => $id, 'value' => $name)) ?>
			<?= CHtml::label($option['label'], $id); ?>
		<?php endif; ?>
		</span>

<?php
		++$i;
	}
?>
	</div>
<?php else: ?>
	<div>
	<?php foreach ($optionsGlobal as $name => $option): ?>
		<span class="toptions">
			<span class="tdata-icon icon-<?= $name; ?>"></span>
			<?php if (isset($option['disabled'])): ?>
				<?= CHtml::label($option['label'], false, array('style' => 'margin-left: 20px; color: gray;')); ?>
			<?php else: ?>
				<span class="spr <?= in_array($name, $options) ? 'checked' : 'unchecked'; ?>"></span>
				<?= CHtml::label($option['label'], false); ?>
			<?php endif; ?>
		</span>
	<?php endforeach; ?>
	</div>
<?php endif; //*/ ?>

<div class="clearfix"></div>

</div>
