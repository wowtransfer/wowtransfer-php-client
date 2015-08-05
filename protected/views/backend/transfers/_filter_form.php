<?php
/* @var $this BackendController */
?>
<div class="portlet" style="margin-top: 10px;">
	<form method="post" action="" onsubmit="return false;" id="frm-filter">
		<div class="portlet-content">
		<div class="portlet-title">Статусы</div>
		<?php foreach (ChdTransfer::getStatuses() as $name => $value): ?>
		<label class="tstatus-<?php echo $name; ?>">
			<input type="checkbox" name="statuses[]"
				   value="<?php echo $name ?>"
				   <?php echo empty($this->filterStatuses) ? 'checked="checked"' : ''; ?>
				   <?php echo in_array($name, $this->filterStatuses) ? 'checked="checked"' : ''; ?>
			>
			<?php echo $value ?>
		</label><br>
		<?php endforeach; ?>

		<div class="portlet-title">Дата/время</div>
		<label><input type="radio" name="dt_range" <?php echo $this->filterDtRange == 0 ? 'checked="checked"' : '' ?> value="0"> все время</label><br>
		<label><input type="radio" name="dt_range" <?php echo $this->filterDtRange == 90 ? 'checked="checked"' : '' ?> value="90"> последниe 3 месяца</label><br>
		<label><input type="radio" name="dt_range" <?php echo $this->filterDtRange == 30 ? 'checked="checked"' : '' ?> value="30"> последний месяц</label><br>
		<label><input type="radio" name="dt_range" <?php echo $this->filterDtRange == 7 ? 'checked="checked"' : '' ?> value="7"> последняя неделя</label><br>
		<label><input type="radio" name="dt_range" <?php echo $this->filterDtRange == 1 ? 'checked="checked"' : '' ?> value="1"> последний день</label>

		<div style="text-align: center; margin: 5px;">
			<button type="submit" name="ftn-filter" class="btn btn-primary" id="btn-filter">Применить</button>
		</div>

	</form>
	</div>
</div>
