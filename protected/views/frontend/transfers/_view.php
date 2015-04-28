<?php
/* @var $this TransfersController */
/* @var $data ChdTransfer */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo $data->id; ?>

	<a href="#" class="btn btn-default btn-sm pull-right" onclick="OnDeleteTransfer(<?php echo $data->id; ?>); return false;">
		<span class="glyphicon glyphicon-remove"></span>
	</a>

	<a href="<?php echo $this->createUrl('/transfers/update', array('id' => $data->id)); ?>"
	   class="btn btn-default btn-sm pull-right" title="Изменить">
		<span class="glyphicon glyphicon-pencil"></span>
	</a>

	<a href="<?php echo $this->createUrl('/transfers/view', array('id' => $data->id)); ?>"
	   class="btn btn-default btn-sm pull-right" title="Просмотр...">
		<span class="glyphicon glyphicon-eye-open"></span>
	</a>

	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<span class="tstatus tstatus-<?php echo $data->status; ?>">
		<?php echo ChdTransfer::getStatusTitle($data->status); ?>
	</span>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_transfer_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_transfer_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('server')); ?>:</b>
	<?php echo CHtml::encode($data->server); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('realmlist')); ?>:</b>
	<?php echo CHtml::encode($data->realmlist); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('realm')); ?>:</b>
	<?php echo CHtml::encode($data->realm); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username_old')); ?>:</b>
	<?php echo CHtml::encode($data->username_old); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username_new')); ?>:</b>
	<?php echo CHtml::encode($data->username_new); ?>
	<br />

	<div><b>Опции переноса:</b>
	<?php $this->widget('application.components.widgets.TransferOptionsWidget', array(
		'model' => $data,
		'options' => $data->getTransferOptionsToUser()
	));	?>
	</div>

</div>