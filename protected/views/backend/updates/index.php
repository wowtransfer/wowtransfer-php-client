<?php
/* @var $this UpdatesController */
/* @var $release array */

$this->breadcrumbs = array(
	'Обновление',
);
?>
<h1>Обновление</h1>

<div>
	Последняя версия приложения
	<div id="latest-version">
		<span class="wait wait16-trans"></span>
	</div>
	<button class="btn btn-default" id="get-lates-version">Проверить</button>
</div>

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

<table>
	<caption>Релиз</caption>
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

<? if (Yii::app()->user->hasFlash('error')): ?>
<div class="alert alert-danger">
	<?= Yii::t('app', 'Error') ?>:
	<?= Yii::app()->user->getFlash('error') ?>
</div>
<? endif ?>

<div style="margin-top: 15px;">
	<?= CHtml::beginForm($this->createUrl('uploadrelease'), 'POST', [
		'enctype' => 'multipart/form-data',
	]) ?>

	<?= CHtml::fileField('archive', null, ['id' => 'archive', 'name' => 'archive']) ?>
	<?= CHtml::submitButton('Загрузить', ['class' => 'btn btn-default']) ?>

	<? if (true): ?>
	<a href="" id="update-app" class="btn btn-default">Обновить</a>
	<? endif ?>

	<? if (isset($release['size'])): ?>
	<a href="<?= $this->createUrl('deleterelease') ?>" class="btn btn-default">
		<?= Yii::t('app', 'Delete') ?>
	</a>
	<? endif ?>

	<?= CHtml::endForm() ?>
</div>

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

