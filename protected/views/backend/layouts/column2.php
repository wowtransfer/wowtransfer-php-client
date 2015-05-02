<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="col-md-9">
	<main id="content">
		<?php echo $content; ?>
	</main><!-- content -->
</div>

<div class="col-md-3">
	<aside>
	<?php
		if (!empty($this->menu)) {
			array_unshift($this->menu, array(
				'label' => 'Операции',
			));
			echo TbHtml::stackedPills($this->menu);
		}
	?>
	</aside>

	<?php foreach ($this->asideBlocks as $block): ?>
	<aside>
		<?php echo $block ?>
	</aside>
	<?php endforeach; ?>

</div>

<?php $this->endContent(); ?>
