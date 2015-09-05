<?php
/* @var $this UpdatesController */
/* @var $release array */
/* @var $appVersion string */
/* @var $appDate string */

$this->breadcrumbs = array(
	'Обновление',
);
?>
<h1>Обновление</h1>

<table id="version-table">
	<thead>
		<tr>
			<th></th>
			<th>Версия</th>
			<th>Дата</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Текущее</td>
			<td>
				<?= $appVersion ?>
			</td>
			<td>
				<?= $appDate ?>
			</td>
			<td></td>
		</tr>
		<tr>
			<td>Новое</td>
			<td id="latest-version">
				<span class="wait wait16-trans"></span>
			</td>
			<td id="latest-date">
				<span class="wait wait16-trans"></span>
			</td>
			<td>
				<button class="btn btn-default btn-sm disabled" id="get-lates-version">Проверить</button>
			</td>
		</tr>
	</tbody>
</table>


<h3>Релиз</h3>

<? if (Yii::app()->user->hasFlash('error')): ?>
<div class="alert alert-danger">
	<?= Yii::t('app', 'Error') ?>:
	<?= Yii::app()->user->getFlash('error') ?>
</div>
<? endif ?>

<?= CHtml::beginForm($this->createUrl('uploadrelease'), 'POST', [
	'enctype' => 'multipart/form-data',
]) ?>

<?= CHtml::fileField('archive', null, ['id' => 'archive', 'name' => 'archive']) ?>
<div style="margin-top: 20px;">
	<?= CHtml::submitButton('Загрузить', ['class' => 'btn btn-primary']) ?>
</div>
	
<?= CHtml::endForm() ?>

<? if (isset($release['size'])): ?>

<h3>Содержимое</h3>

<div style="margin: 15px;">
	<? if (true): ?>
	<a href="" id="update-app" class="btn btn-success disabled">Обновить</a>
	<? endif ?>

	<a href="<?= $this->createUrl('deleterelease') ?>" class="btn btn-danger">
		<?= Yii::t('app', 'Delete') ?>
	</a>
</div>

<table>
	<thead>
		<tr>
			<th>Размер</th>
			<th>Версия</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<?= isset($release['size']) ? round($release['size'] / 1024 / 1024, 3) : '0' ?> Mb
			</td>
			<td>
				
			</td>
		</tr>
	</tbody>
</table>

<? endif ?>


<hr>

<h3>С помощью последнего релиза <span class="label label-success">безопасно</span></h3>

<ul>
	<li>Асинхронно выводим информацию о последней версии приложения</li>
	<li>Скачиваем релиз (zip ~1mb)</li>
	<li>Распаковываем в временную директорию</li>
	<li>Копируем все с заменой, todo: построить дельту для удаленных/измененных/новых файлов</li>
	<li>Запускаем миграции</li>
	<li>Удаляем временные файлы</li>
	<li>Конец</li>
</ul>

<!--
<h3>С помощью последнего исходного кода</h3>
<div class="alert alert-danger">опасно, возможны неточности в интерфейсе и проблемы с миграциями.</div>
<ul>
	<li>Асинхронно выводим информацию об исходном коде</li>
	<li>Скачиваем ветку master (zip ~1mb)</li>
	<li>Распаковываем в временную директорию</li>
	<li>Копируем все с заменой, todo: построить дельту для удаленных/измененных/новых файлов</li>
	<li>Запускаем миграции</li>
	<li>Удаляем временные файлы</li>
	<li>Конец</li>
</ul>

-->