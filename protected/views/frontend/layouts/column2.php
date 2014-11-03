<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div style="float: right; width: 215px;">
	<div id="sidebar">
	<?php
		array_unshift($this->menu, array(
			'label' => 'Операции',
		));
		$this->widget('booster.widgets.TbMenu', array(
			'type' => 'list',
			'stacked' => true,
			'items' => $this->menu,
		));
	?>
	</div>
</div>

<div style="margin: 0 230px 0 0;">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>