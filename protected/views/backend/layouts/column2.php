<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

<div id="sidebar" style="float: right; width: 215px;">

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

	<?php if ($this->action->id === 'index'): ?>

	<div class="portlet" style="margin-top: 10px;">
		<form method="post" action="" onsubmit="return false;" id="frm-filter">
		<div class="portlet-content">
		<div class="portlet-title">Статусы</div>
		<?php foreach (ChdTransfer::getStatuses() as $statusName): ?>
		<label>
			<input type="checkbox" name="statuses[]"
				   value="<?php echo $statusName ?>"
				   <?php echo empty($this->filterStatuses) ? 'checked="checked"' : ''; ?>
				   <?php echo in_array($statusName, $this->filterStatuses) ? 'checked="checked"' : ''; ?>
				   onclick="OnStatusClick(this)">
			<?php echo $statusName ?>
		</label><br>
		<?php endforeach; ?>

		<div class="portlet-title">Дата/время</div>
		<label><input type="radio" name="dt_range" <?php echo $this->filterDtRange == 90 ? 'checked="checked"' : '' ?> value="90"> последниe 3 месяца</label><br>
		<label><input type="radio" name="dt_range" <?php echo $this->filterDtRange == 30 ? 'checked="checked"' : '' ?> value="30"> последний месяц</label><br>
		<label><input type="radio" name="dt_range" <?php echo $this->filterDtRange == 7 ? 'checked="checked"' : '' ?> value="7"> последняя неделя</label><br>
		<label><input type="radio" name="dt_range" <?php echo $this->filterDtRange == 1 ? 'checked="checked"' : '' ?> value="1"> последний день</label>

		<div style="text-align: center;">
			<button type="submit" name="ftn-filter" class="btn btn-primary" id="btn-filter">Применить</button>
		</div>

		</form>
		</div>
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
/*	$.ajax('/transfer/filter',
		data: '',
		method: 'post',
		success: function (data) {
			// Build list view...
		}
	);*/
}

$("#btn-filter").click(function(){
	var form = $("#frm-filter");
	var chbStatuses = form.find('input[name="statuses[]"]:checked');
	var dtRange = form.find('input[name="dt_range"]:checked').val();

	if (!chbStatuses.length) {
		alert("Не выбраны статусы");
		return false;
	}

	var arrStatuses = [];
	chbStatuses.each(function() {
		arrStatuses.push($(this).val());
	});

	$.ajax("", {
		type: "post",
		data: {
			statuses: arrStatuses,
			dt_range: dtRange
		},
		success: function(data) {
			$("#yw0").replaceWith(data);
		}
	});
});

</script>