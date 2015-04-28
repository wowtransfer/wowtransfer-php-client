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
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'htmlOptions' => array(
		'id' => 'toptions-form',
	),
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

		<button type="submit" class="btn btn-primary" disabled="disalbed">
			Save
		</button>

		<a href="<?php echo $this->createUrl('/configs'); ?>" class="btn btn-default">
			<span class="glyphicon glyphicon-ban-circle"></span>
			Cancel
		</a>

	</div>
<?php
$this->endWidget();
unset($form);
?>