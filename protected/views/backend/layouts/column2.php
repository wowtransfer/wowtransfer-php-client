<? /* @var $this Controller */ ?>
<? $this->beginContent('//layouts/main'); ?>

<div class="col-md-9" style="margin: 0; padding: 0;">
	<main id="content">
		<?= $content; ?>
	</main><!-- content -->
</div>

<div class="col-md-3">
	<aside>
	<?
		if (!empty($this->menu)) {
			array_unshift($this->menu, array(
				'label' => 'Операции',
			));
			echo TbHtml::stackedPills($this->menu);
		}
	?>
	</aside>

	<? foreach ($this->asideBlocks as $block): ?>
	<aside>
		<?= $block ?>
	</aside>
	<? endforeach; ?>

</div>

<? $this->endContent(); ?>
