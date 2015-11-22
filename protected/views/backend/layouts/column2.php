<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="col-md-9" style="margin: 0; padding: 0;">
	<main id="content">
		<?= $content; ?>
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
		<?= $block ?>
	</aside>
	<?php endforeach; ?>

</div>

<?php $this->endContent(); ?>
