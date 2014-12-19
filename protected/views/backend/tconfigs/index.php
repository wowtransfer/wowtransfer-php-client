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

<table class="table table-hover">
<thead>
	<tr>
		<th>#</th>
		<th>ID</th>
		<th>Name</th>
		<th>Title</th>
		<th>Update date</th>
		<th>Type</th>
	</tr>
</thead>
<tbody>
<?php foreach ($tconfigs as $i => $config): ?>
	<tr>
		<td><?php echo $i + 1; ?></td>
		<td><?php echo $config['id']; ?></td>
		<td><?php echo $config['name']; ?></td>
		<td><?php echo $config['title']; ?></td>
		<td><?php echo $config['udate']; ?></td>
		<td><?php echo $config['type']; ?></td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>


