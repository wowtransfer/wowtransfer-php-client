<?php
/* @var $this TransfersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Заявки на перенос',
);
?>

<h1>Заявки на перенос</h1>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

<script><!--

window.statuses = [];
<?php foreach (ChdTransfer::getStatuses() as $name => $title): ?>
	window.statuses["<?php echo $name; ?>"] = "<?php echo $title; ?>";
<?php endforeach; ?>

function OnDeleteChar() {
	return confirm('Подтвердите удаление.');
}

function StatusSetHandlers() {
	$(".transfer-statuses a").click(function() {
		var a = $(this);
		var status = a.data("name");
		var id = a.closest("div.view").data("id");
		var eStatus = $("#status_" + id);

		if (eStatus.attr("data-name") === status) {
			return;
		}

		$.ajax("<?php echo Yii::app()->request->scriptUrl; ?>/transfers/update/" + id, {
			type: "post",
			data: {
				status: status
			},
			success: function(data) {
				var checkedStatuses = GetCheckedStatuses();
				if (checkedStatuses.indexOf(status) < 0) {
					$("#view_" + id).hide();
				}
				eStatus.attr("data-name", status);
				eStatus.removeClass();
				eStatus.addClass("tstatus tstatus-" + status);
				eStatus.text(window.statuses[status]);
			},
			error: function (error) {
				alert("Error: " + error);
			}
		});
	});
}
StatusSetHandlers();

--></script>