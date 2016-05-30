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

	<div id="transfer-options-container">
<?php
	$i = 0;
    $checkedCount = 0;
	foreach ($optionsGlobal as $name => $option) {
		$id = "ChdTransfer_transferOptions_$i";
?>
		<span class="toptions">
			<span class="tdata-icon icon-<?= $name; ?>"></span>
		<?php if (isset($option['disabled'])): ?>
			<?= CHtml::label($option['label'], $id, array('style' => 'margin-left: 18px; color: gray;')); ?>
            <?php $checkedCount += 1 ?>
		<?php else: ?>
<?php
            $checked = in_array($name, $options);
            $checkedCount += $checked;
?>
			<?= CHtml::checkBox("ChdTransfer[transferOptions][]", $checked, array('id' => $id, 'value' => $name)) ?>
			<?= CHtml::label($option['label'], $id); ?>
		<?php endif; ?>
		</span>

<?php
		++$i;
	}
?>
        <span class="toptions">
            <span class="tdata-icon"></span>
            <label>
                <input type="checkbox" <?= $checkedCount === count($optionsGlobal) ? 'checked' : '' ?>
                       class="toptions-btn" title="<?= Yii::t('app', 'Set/Unset') ?>">
                <?= Yii::t('app', 'All') ?>
            </label>
        </span>

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
<?php endif ?>

<div class="clearfix"></div>

</div>
