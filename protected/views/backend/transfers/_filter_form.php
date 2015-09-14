<?
/* @var $this BackendController */
?>
<div class="portlet" style="margin-top: 10px;">
	<form method="post" action="" onsubmit="return false;" id="frm-filter">
		<div class="portlet-content">
		<div class="portlet-title"><?= Yii::t('app', 'Statuses') ?></div>
		<? foreach (ChdTransfer::getStatuses() as $name => $value): ?>
		<label class="tstatus-<?= $name; ?>">
			<input type="checkbox" name="statuses[]"
				   value="<?= $name ?>"
				   <?= empty($this->filterStatuses) ? 'checked="checked"' : ''; ?>
				   <?= in_array($name, $this->filterStatuses) ? 'checked="checked"' : ''; ?>
			>
			<?= $value ?>
		</label><br>
		<? endforeach; ?>

		<div class="portlet-title"><?= Yii::t('app', 'Date/Time') ?></div>
		<label><input type="radio" name="dt_range" <?= $this->filterDtRange == 0 ? 'checked="checked"' : '' ?> value="0">
			<?= Yii::t('app', 'All time') ?>
		</label><br>
		<label><input type="radio" name="dt_range" <?= $this->filterDtRange == 90 ? 'checked="checked"' : '' ?> value="90">
			<?= Yii::t('app', 'last 3 months') ?>
		</label>
		<br>
		<label><input type="radio" name="dt_range" <?= $this->filterDtRange == 30 ? 'checked="checked"' : '' ?> value="30">
			<?= Yii::t('app', 'last month') ?>
		</label>
		<br>
		<label><input type="radio" name="dt_range" <?= $this->filterDtRange == 7 ? 'checked="checked"' : '' ?> value="7">
			<?= Yii::t('app', 'last week') ?>
		</label>
		<br>
		<label><input type="radio" name="dt_range" <?= $this->filterDtRange == 1 ? 'checked="checked"' : '' ?> value="1">
			<?= Yii::t('app', 'last day') ?>
		</label>

	</form>
	</div>
</div>
