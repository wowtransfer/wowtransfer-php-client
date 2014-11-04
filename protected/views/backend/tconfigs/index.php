<?php
/* @var $this TconfigsController */
/* @var $tconfigs array */

$this->breadcrumbs = array(
	'Конфигурации переноса',
);
?>

<table class="table" style="width: 50%">
<thead>
	<tr>
		<th>ID</th>
		<th>Title</th>
	</tr>
</thead>
<tbody>
<?php foreach ($tconfigs as $id => $title): ?>
	<tr>
		<td><?php echo $id; ?></td>
		<td><?php echo $title; ?></td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>


