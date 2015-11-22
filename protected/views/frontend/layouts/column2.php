<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="col-md-9">
	<main>
		<?= $content; ?>
	</main><!-- content -->
</div>

<div class="col-md-3">
	<aside>
	<?
		//array_unshift($this->menu, array('label' => 'Операции'));
		echo TbHtml::stackedPills($this->menu); ?>
	</aside>
</div>

<?php $this->endContent(); ?>