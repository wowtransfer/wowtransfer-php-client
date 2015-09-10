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

<div class="row">
	<div class="col-md-6">

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

	</div>
	<div class="col-md-6">

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

	</div>
</div>





<? if (isset($release['size'])): ?>

<div class="row">

	<div class="col-md-6">
		<h3>Содержимое</h3>

		<p>
			<a href="<?= $this->createUrl('updateApplication') ?>"
			   id="update-app" class="btn btn-success">
				<?= Yii::t('app', 'Update') ?>
			</a>
			<a href="<?= $this->createUrl('deleterelease') ?>" class="btn btn-danger">
				<?= Yii::t('app', 'Delete') ?>
			</a>
		</p>
		<div class="alert alert-danger">
			Обновление перепишет все файлы.
		</div>

		<div>
			Размер:
			<?= isset($release['size']) ? round($release['size'] / 1024 / 1024, 3) : '0' ?> Mb
		</div>

		<? if (is_array($release['file_names'])): ?>
		<span>Файлы:</span>
		<ol id="release-file-list" style="height: 200px;" data-count="<?= count($release['file_names']) ?>">
			<? foreach ($release['file_names'] as $i => $name): ?>
				<li><?= $name ?></li>
			<? endforeach ?>
		</ol>
		<? endif ?>

	</div>
	<div class="col-md-6 hidden" id="updating-process-block">
		<h3>Процесс обновления</h3>

		<ul id="upading-actions" class="list-group">
			<li data-action="extract" class="list-group-item">
				Распаковка архива
			</li>
			<li data-action="copy_files" class="list-group-item">
				Копирование файлов
			</li>
			<li data-action="delete_files" class="list-group-item">
				Удаление файлов
			</li>
			<li data-action="concat" class="list-group-item">
				Сжатие ресурсов
			</li>
			<li data-action="minify" class="list-group-item">
				Минификация ресурсов
			</li>
			<li data-action="delete_temp_files" class="list-group-item">
				Удаление временных файлов
			</li>
		</ul>

		<div id="updating-total-message">
			Обновление прошло успешно.
		</div>

	</div>
</div>


<? endif ?>
