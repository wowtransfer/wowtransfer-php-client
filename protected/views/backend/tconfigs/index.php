<?php

/* @var $this TconfigsController */
/* @var $tconfigs array */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer configurations')
];
?>

<div class="alert alert-info">
	<a class="alert-link" href="http://wowtransfer.com/cp/tconfigs/">
		<?= Yii::t('app', 'Use the service for configuration edit') ?>
	</a>
</div>

<?php if (empty($tconfigs)): ?>

<div class="alert alert-info"><?= Yii::t('app', 'No data') ?></div>

<?php else: ?>

<table class="table table-hover table-cursored" id="tconfigs-table">
	<col style="width: 40px;">
	<col>
	<col>
	<col style="width: 100px;">
	<col style="width: 70px;">
<thead>
	<tr>
		<th>#</th>
		<th><?= Yii::t('app', 'Name') ?></th>
		<th><?= Yii::t('app', 'Description') ?></th>
		<th><?= Yii::t('app', 'Change date') ?></th>
		<th><?= Yii::t('app', 'Type') ?></th>
	</tr>
</thead>
<tbody>
<?php foreach ($tconfigs as $i => $config): ?>
	<tr data-id="<?= $config['id']; ?>">
		<td><?= $i + 1; ?></td>
		<td><?= CHtml::encode($config['name']); ?></td>
		<td><?= CHtml::encode($config['title']); ?></td>
		<td><?= CHtml::encode($config['update_date']); ?></td>
		<td><?= WowtransferUI::getTransferConfigType($config['type']); ?></td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php endif ?>

<?php

$url = $this->createUrl("/tconfigs/view");
Yii::app()->clientScript->registerScript('goto_tconfig', '
$("#tconfigs-table").on("click", "td", function() {
	var id = $(this).closest("tr").data("id");
	window.location.href = "' . $url . '?id=" + id;
});'
); ?>
