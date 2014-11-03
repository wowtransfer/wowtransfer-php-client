<?php
/* @var $model ChdTransfer */
/* @var $this TransfersController */
/* @var $luaDumpContent string Source content */
/* @var $luaDumpContentZip string Zipped content */

$this->breadcrumbs = array(
	'Заявки на перенос' => array('/transfers'),
	$model->id => array('view', 'id' => $model->id),
	'Lua-дамп'
);

$this->menu = array(
	array('label'=>'Список заявок', 'url'=>array('index'), 'icon' => 'list'),
	
);

$luaDumpSize = strlen($luaDumpContent);
$luaDumpZipSize = strlen($luaDumpContentZip);
?>

<h1>Lua-дамп персонажа</h1>


<table class="table table-bordered">
<tbody>
	<tr>
		<td></td>
		<th>bytes</th>
		<th>kbytes</th>
	</tr>
	<tr>
		<th>Исходный размер</th>
		<td><?php echo $luaDumpSize; ?></td>
		<td><?php echo $luaDumpSize >> 10; ?></td>
	</tr>
	<tr>
		<th>Сжатый размер</th>
		<td><?php echo $luaDumpZipSize; ?></td>
		<td><?php echo $luaDumpZipSize >> 10; ?></td>
	</tr>
	<tr>
		<th>Коэфициент сжатия</th>
		<td colspan="2" class="text-center"><?php echo round($luaDumpSize / $luaDumpZipSize, 3); ?></td>
	</tr>
</tbody>
</table>


<h3>Исходный lua-дамп</h3>

<pre style="height: 400px; margin-top: 10px;"><?php echo strip_tags(htmlspecialchars($luaDumpContent)); ?></pre>

<h3>Сжатый lua-дамп</h3>

<pre style="height: 400px; margin-top: 10px;"><?php echo bin2hex($luaDumpContentZip); ?></pre>