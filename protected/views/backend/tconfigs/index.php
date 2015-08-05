<?php
/* @var $this TconfigsController */
/* @var $tconfigs array */

$this->breadcrumbs = array(
	'Конфигурации переноса',
);
?>

<div class="alert alert-info">
	Воспользуйтесь сервисом для <a class="alert-link" href="http://wowtransfer.com/cp/tconfigs/">редактирования конфигурации</a>. 
</div>

<? if (empty($tconfigs)): ?>

<div class="alert alert-info">Нет данных</div>

<? else: ?>

<table class="table table-hover table-cursored" id="tconfigs-table">
	<col style="width: 40px;">
	<col>
	<col>
	<col style="width: 100px;">
	<col style="width: 70px;">
<thead>
	<tr>
		<th>#</th>
		<th>Name</th>
		<th>Title</th>
		<th>Update date</th>
		<th>Type</th>
	</tr>
</thead>
<tbody>
<?php foreach ($tconfigs as $i => $config): ?>
	<tr data-id="<?php echo $config['id']; ?>">
		<td><?php echo $i + 1; ?></td>
		<td><?php echo CHtml::encode($config['name']); ?></td>
		<td><?php echo CHtml::encode($config['title']); ?></td>
		<td><?php echo CHtml::encode($config['update_date']); ?></td>
		<td><?php echo WowtransferUI::getTransferConfigType($config['type']); ?></td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>

<? endif ?>

<?php
$url = $this->createUrl("/tconfigs/view");
Yii::app()->clientScript->registerScript('goto_tconfig', '
$("#tconfigs-table").on("click", "td", function() {
	var id = $(this).closest("tr").data("id");
	window.location.href = "' . $url . '?id=" + id;
});'
); ?>
