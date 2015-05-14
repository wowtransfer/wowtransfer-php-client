<?php
/* @var $this ConfigsController */
/* @var $whiteServers array */
/* @var $blackServers array */

$this->breadcrumbs = array(
	'Настройка' => array('/configs'),
	'Удаленные сервера',
);

?>

<h1>Удаленные сервера</h1>

<p>Удаленные сервера World of Warcraft с которых можно переносить персонажей.</p>

<p>
	По-умолчанию все сервера, зарегистрированные на сервисе, находятся в черном списке,
	то есть переносить с них персонажей нельзя.
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
		<h3>Черный список</h3>
		<?php if (empty($blackServers)): ?>
			<div class="alert alert-info">Нет данных</div>
		<?php else: ?>
			<ul>
			<?php foreach ($blackServers as $server): ?>
				<li><?php echo $server['title'] ?></li>
			<?php endforeach; ?>
			</ul>
		<?php endif ?>
	</div>
	<div class="col-md-6">
		<h3>Белый список</h3>
		<?php if (empty($whiteServers)): ?>
			<div class="alert alert-info">Нет данных</div>
		<?php else: ?>
		<ul>
			<?php foreach ($blackServers as $server): ?>
				<li></li>
			<?php endforeach; ?>
		</ul>
		<?php endif ?>
	</div>
</div>

