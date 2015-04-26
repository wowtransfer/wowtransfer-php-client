<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="col-md-10">
	<main>
		<?php echo $content; ?>
	</main><!-- content -->
</div>

<div class="col-md-2">
	<aside>
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
	</aside>
</div>

<?php $this->endContent(); ?>