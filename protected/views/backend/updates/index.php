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
			<th><?= Yii::t('app', 'Version') ?></th>
			<th><?= Yii::t('app', 'Date') ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><?= Yii::t('app', 'Current') ?></td>
			<td>
				<?= $appVersion ?>
			</td>
			<td>
				<?= $appDate ?>
			</td>
		</tr>
		<tr>
			<td><?= Yii::t('app', 'New') ?></td>
			<td id="latest-version">
				<span class="wait wait16-trans"></span>
			</td>
			<td id="latest-date">
				<span class="wait wait16-trans"></span>
			</td>
			<td>
				<a href="<?= $this->createUrl('/updates/downloadLatestRelease') ?>"
				   class="btn btn-success hidden" id="download-latest-version">
					<?= Yii::t('app', 'Download') ?>
				</a>
			</td>
		</tr>
	</tbody>
</table>


<h3><?= Yii::t('app', 'Release') ?></h3>

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
	<?= CHtml::submitButton(Yii::t('app', 'Upload'), ['class' => 'btn btn-primary']) ?>
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

<div>
	Размер:
	<?= isset($release['size']) ? round($release['size'] / 1024 / 1024, 3) : '0' ?> Mb
</div>

<? if (is_array($release['file_names'])): ?>
<span>Файлы:</span>
<ol id="release-file-list" data-count="<?= count($release['file_names']) ?>">
	<? foreach ($release['file_names'] as $i => $name): ?>
		<li><?= $name ?></li>
	<? endforeach ?>
</ol>
<? endif ?>

<? endif ?>

<!--
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
-->

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