<?php
/* @var $this SiteController */
?>
<h1><?= Yii::t('app', 'Administration') ?></h1>

<ul>

	<li><a href="<?= $this->createUrl('/transfers') ?>">Заявки на перенос</a>
		<ul>
			<li>Просмотр, изменение и удаление заявок.</li>
			<li>Создание персонажей.</li>
			<li>Просмотр lua-дампов</li>
		</ul>
	</li>

	<li><a href="<?= $this->createUrl('/tconfigs/index'); ?>">Конфигурации переноса</a>
		<ul>
			<li>Просмотр конфигураций переноса.</li>
		</ul>
	</li>

	<li><a href="<?= $this->createUrl('/configs'); ?>">Настройка</a>
		<ul>
			<li>
				<a href="<?= $this->createUrl('/configs/app'); ?>">
					<?= Yii::t('app', 'Application') ?>
				</a>
			</li>
			<li><a href="<?= $this->createUrl('/configs/service'); ?>">Связь с сервисом</a></li>
			<li><a href="<?= $this->createUrl('/configs/toptions'); ?>"><?= Yii::t('app', 'Transfer options') ?></a></li>
			<li><a href="<?= $this->createUrl('/configs/remoteservers') ?>">Удаленные сервера</a></li>
		</ul>
	</li>

</ul>