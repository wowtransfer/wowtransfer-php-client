<?php
/* @var $this ConfigsController */

$this->breadcrumbs = array(
	'Настройка' => array('/configs'),
	'Опции переноса',
);
?>

<h1 class="text-center">Опции переноса</h1>

<?php
$this->beginWidget('booster.widgets.TbActiveForm', array(

)); ?>

	<table class="table">
	<thead>
	<tr>
		<th></th>
		<th>Name</th>
		<th>Title</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($options as $name => $option): ?>
	<tr class="toptions-row">
		<td><?php echo CHtml::checkBox('chb_' . $name, !isset($option['disabled'])); ?></td>
		<td><?php echo CHtml::label($name, $name); ?></td>
		<td><?php echo $option['label']; ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
	</table> 

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'context' => 'primary',
			'label' => 'Save',
		)); ?>
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'link',
			'label' => 'Cancel',
			'url' => $this->createUrl('/configs'),
			'icon' => 'ban-circle',
		)); ?>
	</div>
<?php $this->endWidget(); ?>