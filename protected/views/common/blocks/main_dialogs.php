<!-- ok/cancel -->
<div class="modal fade" id="common-dialog-okcancel" tabindex="-1" role="dialog" aria-labelledby="common-dialog-okcancel-title">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="common-dialog-okcancel-title">
					<?= Yii::t('app', 'Confirmation') ?>
				</h4>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">OK</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<?= Yii::t('app', 'Cancel') ?>
				</button>
			</div>
		</div>
	</div>
</div>
