<?php
/* @var $this ConfigsController */

$this->breadcrumbs = array(
	'Настройка' => array('/configs'),
	'Опции переноса',
);
?>

<h1 class="text-center">Опции переноса</h1>

<div class="alert alert-warning">
TODO: файл <code>/protected/config/toptions.php</code> редактируется в ручную.
</div>

<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'id' => 'toptions-form',
)); ?>

	<table class="table table-condensed table-hover">
	<thead>
	<tr>
		<th></th>
		<th>Title</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($options as $name => $option): ?>
	<tr class="toptions-row">
		<td><?php echo CHtml::checkBox('toptions[' . $name . ']', !isset($option['disabled'])); ?></td>
		<td><?php echo $option['label']; ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table> 

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context' => 'primary',
			'label' => 'Save',
			'htmlOptions' => array(
				'disabled' => 'disalbed',
			),
		)); ?>
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'link',
			'label' => 'Cancel',
			'url' => $this->createUrl('/configs'),
			'icon' => 'ban-circle',
		)); ?>
	</div>
<?php
$this->endWidget();
unset($form);
?>