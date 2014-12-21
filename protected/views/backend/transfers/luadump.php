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
		<td class="text-right"><?php echo $luaDumpSize; ?></td>
		<td class="text-right"><?php echo $luaDumpSize >> 10; ?></td>
	</tr>
	<tr>
		<th>Сжатый размер</th>
		<td class="text-right"><?php echo $luaDumpZipSize; ?></td>
		<td class="text-right"><?php echo $luaDumpZipSize >> 10; ?></td>
	</tr>
	<tr>
		<th>Коэфициент сжатия</th>
		<td colspan="2" class="text-center"><?php echo round($luaDumpSize / $luaDumpZipSize, 3); ?></td>
	</tr>
</tbody>
</table>


<h3>Исходный lua-дамп</h3>

<pre style="height: 300px; margin-top: 10px;"><?php echo strip_tags(htmlspecialchars($luaDumpContent)); ?></pre>

<h3>Сжатый lua-дамп</h3>

<pre style="height: 100px; margin-top: 10px;"><?php echo bin2hex($luaDumpContentZip); ?></pre>

<div class="form">
	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'label' => 'Назад',
			'buttonType' => 'link',
			'url' => Yii::app()->request->urlReferrer,
		)); ?>
	</div>
</div>