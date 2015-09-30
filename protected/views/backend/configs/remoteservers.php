<?
/* @var $this ConfigsController */
/* @var $whiteServers array */
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

<? if (empty($whiteServers)): ?>
	<div class="alert alert-info">Нет данных</div>
<? else: ?>
<?= CHtml::beginForm() ?>

	<? if (Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success"><?= Yii::app()->user->getFlash('success') ?></div>
	<? endif ?>
	<? if (Yii::app()->user->hasFlash('error')): ?>
	<div class="alert alert-danger"><?= Yii::app()->user->getFlash('error') ?></div>
	<? endif ?>

	<table class="table table-bordered">
		<thead>
			<tr>
				<th colspan="4"></th>
				<th><?= Yii::t('app', 'Exclude') ?></th>
			</tr>
		</thead>
	<tbody>
	<? foreach ($whiteServers as $server): ?>
		<tr data-type="server">
			<th colspan="4">
				<?= $server['name'] ?>
			</th>
			<td></td>
		</tr>
		<? foreach ($server['realms'] as $realm): ?>
		<tr data-type="realm" data-id="<?= $realm['id'] ?>">
			<td><?= $realm['name'] ?></td>
			<td><?= $realm['rate'] ?></td>
			<td><?= $realm['online_count'] ?></td>
			<td><?= $realm['wow_version'] ?></td>
			<td style="width: 40px;">
				<input type="checkbox" name="realms[<?= $realm['id'] ?>]"
					   <?= in_array($realm['id'], $blackRealms) ? ' checked ' : '' ?> >
			</td>
		</tr>
		<? endforeach ?>
	<? endforeach; ?>
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

<? CHtml::endForm() ?>
<? endif ?>
