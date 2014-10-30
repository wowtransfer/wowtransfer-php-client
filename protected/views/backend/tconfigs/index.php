<?php
/* @var $this TconfigsController */
/* @var $tconfigs array */

$this->breadcrumbs = array(
	'Конфигурации переноса',
);
?>

<ul>
<?php foreach ($tconfigs as $tconfig): ?>
	<li><?php echo $tconfig['name'] . ' - ' . $tconfig['title']; ?></li>
<?php endforeach; ?>
</ul>


