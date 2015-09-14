<?
/* @var $model ChdTransfer */
/* @var $this TransfersController */
/* @var $luaDumpContent string Source content */
/* @var $luaDumpContentZip string Zipped content */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer requests') => ['/transfers'],
	' ' . $model->id => ['view', 'id' => $model->id], // TODO: hack
	Yii::t('app', 'Lua dump')
];

$this->menu = [
	['label' => Yii::t('app', 'Requests list'), 'url'=> ['index'], 'icon' => 'list'],
];

$luaDumpSize = strlen($luaDumpContent);
$luaDumpZipSize = strlen($luaDumpContentZip);
?>

<h1><?= Yii::t('app', 'Lua dump') ?></h1>


<table class="table table-bordered">
<tbody>
	<tr>
		<td></td>
		<th>bytes</th>
		<th>kbytes</th>
	</tr>
	<tr>
		<th>Исходный размер</th>
		<td class="text-right"><?= $luaDumpSize; ?></td>
		<td class="text-right"><?= $luaDumpSize >> 10; ?></td>
	</tr>
	<tr>
		<th>Сжатый размер</th>
		<td class="text-right"><?= $luaDumpZipSize; ?></td>
		<td class="text-right"><?= $luaDumpZipSize >> 10; ?></td>
	</tr>
	<tr>
		<th>Коэфициент сжатия</th>
		<td colspan="2" class="text-center"><?= round($luaDumpSize / $luaDumpZipSize, 3); ?></td>
	</tr>
</tbody>
</table>


<h3>Исходный lua-дамп</h3>

<pre style="height: 300px; margin-top: 10px;"><?= strip_tags(htmlspecialchars($luaDumpContent)); ?></pre>

<h3>Сжатый lua-дамп</h3>

<pre style="height: 100px; margin-top: 10px;"><?= bin2hex($luaDumpContentZip); ?></pre>

<div class="form">
	<div class="form-actions">
		<a href="<?= Yii::app()->request->urlReferrer; ?>" class="btn btn-default">
			Назад
		</a>
	</div>
</div>