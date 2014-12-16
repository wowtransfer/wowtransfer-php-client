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
	<?php if ($this->action->id === 'index'): ?>
	<!-- TODO: do widget -->
	<div><h4>Статусы</h4>
		<?php foreach (ChdTransfer::getStatuses() as $statusName): ?>
		<label>
			<input type="checkbox" name="status_<?php echo $statusName ?>"
				   value="<?php echo $statusName ?>" checked="checked"
				   onclick="OnStatusClick(this)">
			<?php echo $statusName ?>
		</label><br>
		<?php endforeach; ?>
	</div>
	<div><h4>Дата/время</h4>
		<label><input type="radio" name="dt_last_month" value="last_month" checked="checked"> последний месяц</label><br>
		<label><input type="radio" name="dt_last_month" value="last_week"> последняя неделя</label><br>
		<label><input type="radio" name="dt_last_month" value="last_day"> последний день</label>
	</div>
	<div style="text-align: center;">
		<button type="submit" class="btn btn-primary">Применить</button>
	</div>
	<?php endif; ?>
</div>

<div style="margin: 0 230px 0 0;">
	<div id="content">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>

<script>
function OnStatusClick(checkbox)
{
	$.ajax('/transfer/filter',
		data: '',
		method: 'post',
		success: function (data) {
			// Build list view...
		}
	);
}
</script>