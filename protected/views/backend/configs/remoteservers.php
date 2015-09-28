<?
/* @var $this ConfigsController */
/* @var $whiteServers array */
/* @var $blackServers array */

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

<p>Данные синхронизируются с сервисом раз в сутки.
	Для ручной синхронизации нужно нажать кнопку <i>Синхронизация</i>.
</p>

<div>
	<a class="btn btn-success pull-right">Синхронизация</a>
</div>
<div class="clearfix"></div>

<div class="row">
	<div class="col-md-6">
		<h3>Общее</h3>
		<? if (empty($whiteServers)): ?>
			<div class="alert alert-info">Нет данных</div>
		<? else: ?>
			<table class="table table-bordered">
			<tbody>
			<? foreach ($whiteServers as $server): ?>
				<tr data-type="server">
					<th colspan="4">
						<?= $server['name'] ?>
					</th>
					<td>
						<button class="btn btn-default">
							<span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</td>
				</tr>
				<? foreach ($server['realms'] as $realm): ?>
				<tr data-type="realm" data-id="<?= $realm['id'] ?>">
					<td><?= $realm['name'] ?></td>
					<td><?= $realm['rate'] ?></td>
					<td><?= $realm['online_count'] ?></td>
					<td><?= $realm['wow_version'] ?></td>
					<td>
						<button class="btn btn-default">
							<span class="glyphicon glyphicon-menu-right"></span>
						</button>
					</td>
				</tr>
				<? endforeach ?>
			<? endforeach; ?>
			</tbody>
		</table>
		<? endif ?>
	</div>
	<div class="col-md-6">
		<h3>Исключить</h3>
		<? if (empty($blackServers)): ?>
			<div class="alert alert-info">Нет данных</div>
		<? else: ?>
			<ul>
			<? foreach ($blackServers as $server): ?>
				<li><?= $server['title'] ?></li>
			<? endforeach; ?>
			</ul>
		<? endif ?>
	</div>
</div>
