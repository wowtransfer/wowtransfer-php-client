/**
 * @var {
 */
var app = app || {};

(function($) {

	var transfers = {};

	function getFilterCheckedStatuses($form) {
		if ($form === undefined) {
			$form = $("#frm-filter");
		}

		var chbStatuses = $form.find('input[name="statuses[]"]:checked');
		var arrStatuses = [];

		chbStatuses.each(function() {
			arrStatuses.push($(this).val());
		});

		return arrStatuses;
	};


	$(function() {

		$("#transfers-listview").on("click", ".transfer-save-comment", function() {
			var $view = $(this).closest(".view"),
				id = $view.data("id"),
				comment = $view.find(".transfer-comment").val();
			var requestData = {
				comment: comment
			};
			$.post(app.getBaseUrl() + "/transfers/update/" + id, requestData, function(data) {
					app.showMessage("Комментарий изменен");
			});
		});

		$("#transfers-listview").on("click", ".transfer-statuses a", function() {
			var $a = $(this),
				status = $a.data("name"),
				id = $a.closest(".view").data("id"),
				$status = $("#status_" + id);

			if ($status.attr("data-name") === status) {
				return;
			}

			var requestData = {
				status: status
			};
			$.post(app.getBaseUrl() + "/transfers/update/" + id, requestData, function(data) {
				var checkedStatuses = getFilterCheckedStatuses();
				if (checkedStatuses.indexOf(status) < 0) {
					$("#view_" + id).hide();
				}
				$status.attr("data-name", status);
				$status.removeClass();
				$status.addClass("tstatus tstatus-" + status);
				$status.text(window.statuses[status]);
			});
		});

		$("#transfers-listview").on("click", ".delete-char", function() {
			if (!confirm("Подтвердите удаление персонажа")) {
				return false;
			}

			app.beginLoading("Удаление персонажа...");

			var $btnDelChar = $(this);
			var id = $btnDelChar.closest("view").data("id");
			var url = $btnDelChar.attr("href");
			console.log(url);
			$.ajax(url, {
				type: "post",
				success: function (data) {
					app.endLoading();
					if (data.error !== undefined) {
						app.showMessage(data.error);
					}
					else {
						app.showMessage("Персонаж удален");
					}
					$btnDelChar.hide();
					$("#btn-create-char-" + id).show();
				},
				error: function () {
					app.endLoading();
				}
			}, "json");
		});

		$("#btn-filter").click(function() {
			var $form = $("#frm-filter"),
				dtRange = $form.find('input[name="dt_range"]:checked').val(),
				checkedStatuses = getFilterCheckedStatuses($form);

			if (!checkedStatuses.length) {
				alert("Не выбраны статусы");
				return false;
			}

			var requestData = {
				statuses: checkedStatuses,
				dt_range: dtRange
			};
			$.post("", requestData, function(data) {
				$("#transfers-listview").replaceWith(data);
			});
		});

		$(".switch-password").click(function() {
			var $btn = $(this);
			var id = $("#transfer").data("id");
			var $pass = $("#password_" + id);
			var pass = $pass.data("password");
			if (pass) {
				if ($pass.text().indexOf("*******") !== -1) {
					$pass.text(pass);
					$btn.text("-");
				}
				else {
					$pass.text("*******");
					$btn.text("+");
				}
			}
			else {
				$.post(app.getBaseUrl() + "/transfers/remotepassword/" + id, {}, function(data) {
					console.log(data);
					$pass.text(data);
					$pass.data("password", data);
					$btn.text("-");
				});
			}
			return false;
		});

	});

	return transfers;

})(window.jQuery);