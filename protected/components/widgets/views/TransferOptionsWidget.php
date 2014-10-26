<?php
/*
Show transfer's options

option item has:
- name
- title
- icon (name, URL)
- large image (optionally, depends of icon's name)

*/
?>

<script><!--
function TransferOptionsToggle(method) {
	var checkboxes = $('#transfer-options-container input');

	switch (method) {
		case 0: checkboxes.prop('checked', false); break;
		case 1: checkboxes.prop('checked', true); break;
		case 2: checkboxes.prop('checked', function (i, value) {
			return !value;
		});
	}
}
--></script>

<div class="well well-small">

<?php
/*
$options = array_merge($options, array(
	'achievement' => array(
		'disabled' => 1
	),
	
	)
);*/

//CVarDumper::dump($readonly, 10, true);

/*echo CHtml::activeCheckBoxList($model, 'transferOptions', $options, array(
	'template' => '<span class="toptions readonly">{input} {label}</span>',
	'separator' => '',
	'class' => 'inline-chb'));//*/
?>

<?php
$optionsGlobal = Wowtransfer::getTransferOptions();
$options = explode(';', $model->options);
///CVarDumper::dump($options, 10, true);
?>

<?php if (!$readonly): ?>
	<div class="pull-right">
		<?php $this->widget('booster.widgets.TbButton', array(
			'label' => '+',
			'size' => 'small',
			'htmlOptions' => array('style' => 'width: 30px; margin-bottom: 5px;', 'title' => 'Установить', 'onclick' => 'TransferOptionsToggle(1)'),
		)); ?>
		<br>
		<?php $this->widget('booster.widgets.TbButton', array(
			'label' => '-',
			'size' => 'small',
			'htmlOptions' => array('style' => 'width: 30px; margin-bottom: 5px;', 'title' => 'Убрать', 'onclick' => 'TransferOptionsToggle(0)'),
		)); ?>
		<br>
		<?php $this->widget('booster.widgets.TbButton', array(
			'label' => '+-',
			'size' => 'small',
			'htmlOptions' => array('style' => 'width: 30px;', 'title' => 'Инвертировать', 'onclick' => 'TransferOptionsToggle(2)'),
		)); ?>
	</div>

<?php
	$i = 0;
	foreach ($optionsGlobal as $name => $option) {
		$id = "ChdTransfer_transferOptions_$i";
?>
	<div id="transfer-options-container">
		<span class="toptions">
			<span class="tdata-icon icon-<?php echo $name; ?>"></span>
		<?php if (isset($option['disabled'])): ?>
			<?php echo CHtml::label($option['label'], $id, array('style' => 'margin-left: 18px; color: gray;')); ?>
		<?php else: ?>
			<?php echo CHtml::checkBox("ChdTransfer[transferOptions][]", in_array($name, $options), array('id' => $id, 'value' => $name)) ?>
			<?php echo CHtml::label($option['label'], $id); ?>
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
			<span class="tdata-icon icon-<?php echo $name; ?>"></span>
			<?php if (isset($option['disabled'])): ?>
				<?php echo CHtml::label($option['label'], false, array('style' => 'margin-left: 20px; color: gray;')); ?>
			<?php else: ?>
				<?php if (in_array($name, $options)): ?>
					<img width="16" height="16" alt="" title="checked" src="<?php echo Yii::app()->baseUrl; ?>/images/checked.png">				
				<?php else: ?>
					<img width="16" height="16" alt="" title="unchecked" src="<?php echo Yii::app()->baseUrl; ?>/images/unchecked.png">
				<?php endif; ?>
				<?php echo CHtml::label($option['label'], false); ?>
			<?php endif; ?>
		</span>
	<?php endforeach; ?>
	</div>
<?php endif; //*/ ?>

<div class="clearfix"></div>

</div>

<?php

Yii::app()->getClientScript()->registerScript('UpdateTransferOptionsButtons', '', CClientScript::POS_END);



