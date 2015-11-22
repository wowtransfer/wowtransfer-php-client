<?
/* @var $this ConfigsController */
/* @var $wowServers Wowserver[] */
/* @var $blackRealms int[] */

$this->breadcrumbs = [
	Yii::t('app', 'Settings') => ['/configs'],
	Yii::t('app', 'Remote servers')
];
?>

<h1><?= Yii::t('app', 'Remote servers') ?></h1>

<p>Удаленные сервера World of Warcraft с которых можно переносить персонажей.</p>

<p>
	По-умолчанию все сервера, зарегистрированные на сервисе, находятся в общем списке,
	то есть с них можно переносить персонажей.
</p>

<!--
<p>Данные синхронизируются с сервисом раз в сутки.
	Для ручной синхронизации нужно нажать кнопку <i>Синхронизация</i>.
</p>

<div>
	<a class="btn btn-success pull-right">Синхронизация</a>
</div>
-->

<div class="clearfix"></div>

<?php if (empty($wowServers)): ?>
	<div class="alert alert-info">Нет данных</div>
<?php else: ?>
<?= CHtml::beginForm() ?>

	<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success"><?= Yii::app()->user->getFlash('success') ?></div>
	<?php endif ?>
	<?php if (Yii::app()->user->hasFlash('error')): ?>
	<div class="alert alert-danger"><?= Yii::app()->user->getFlash('error') ?></div>
	<?php endif ?>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th colspan="4"></th>
				<th><?= Yii::t('app', 'Exclude') ?></th>
			</tr>
		</thead>
	<tbody>
	<?php foreach ($wowServers as $server): ?>
		<tr data-type="server">
			<th colspan="4">
				<?= $server->getName() ?>
			</th>
			<td></td>
		</tr>
		<?php foreach ((array)$server->getRealms() as $realm): ?>
		<tr data-type="realm" data-id="<?= $realm->getId() ?>">
			<td><?= $realm->getName() ?></td>
			<td><?= $realm->getRate() ?></td>
			<td><?= $realm->getOnlineCount() ?></td>
			<td><?= $realm->getWowVersion() ?></td>
			<td style="width: 40px;">
				<input type="checkbox" name="realms[<?= $realm->getId() ?>]"
					   <?= in_array($realm->getId(), $blackRealms) ? ' checked ' : '' ?> >
			</td>
		</tr>
		<?php endforeach ?>
	<?php endforeach; ?>
	</tbody>
	</table>

	<div>
		<button class="btn btn-primary">
			<?= Yii::t('app', 'Save') ?>
		</button>
		<a class="btn btn-default" href="<?= $this->createUrl('/configs') ?>">
			<?= Yii::t('app', 'Cancel') ?>
		</a>
	</div>

<?php CHtml::endForm() ?>
<?php endif ?>
