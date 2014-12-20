<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */
/* @var $error string */
/* @var $queries array */
/* @var $queriesCount integer */
/* @var $sql string */
/* @var $tconfigs array Transfer's configurations */

$this->breadcrumbs = array(
	'Заявки на перенос' => array('index'),
	$model->id => array('view', 'id' => $model->id),
	'Создание персонажа',
);

?>

<div style="float: right; width: 300px;">
	<a class="btn btn-default btn-sm btn-char-action" href="#"
		onclick="OnClearCharacterDataByTransferIdClick(<?php echo $model->id; ?>); return false;">
		Clear character's data by GUID and ID
	</a> <span class="label label-success">safe</span><br>
	<a class="btn btn-default btn-sm btn-char-action" href="#"
		onclick="return OnClearCharacterDataByGuidClick(<?php echo $model->id; ?>, <?php echo $model->char_guid; ?>); return false;">
		Clear character's data by GUID
	</a> <span class="label label-danger btn-char-action">unsafe</span><br>
	<a class="btn btn-default btn-sm btn-char-action" href="#"
		onclick="OnShowCharacterDataClick(<?php echo $model->char_guid; ?>); return false;">
		Show character's info by GUID and ID
	</a><br>
	<a class="btn btn-default btn-sm btn-char-action" href="#" onclick="alert('TODO');">View SQL script</a><br />
	<a class="btn btn-default btn-sm" href="#"
		data-toggle="modal"
		onclick="OnViewLuaDumpClick(<?php echo $model->id; ?>); return false;"
		> <!--data-target="#lua-dump-dialog"-->
		lua-dump
	</a>
	<a class="btn btn-default btn-sm" href="#"
		onclick="OnViewUncryptedLuaDumpClick(<?php echo $model->id; ?>); return false;"
		>uncripted lua-dump</a>
</div>

<div style="margin: 5px 305px 5px 0; height: 160px;">

<div>
	<div style="float: left; padding: 3px;">
		<b>Создана</b><br><?php echo $model->create_transfer_date; ?><br>
		<b>Статус</b><br> <?php echo $model->status; ?>
	</div>

	<div style="float: left; padding: 3px;">
		<b>Сервер</b><br>
		<?php echo $model->server; ?><br>
		<b>Реалмлист</b><br>
		<?php echo $model->realmlist; ?><br>
		<b>Реалм</b><br>
		<?php echo $model->realm; ?>
	</div>

	<div style="float: left; padding: 3px;">
		<b>Аккаунт</b><br>
		<?php echo $model->account; ?><br>
		<b>Пароль <input type="checkbox" name="show-password" title="Show/Hide password"
			onclick="var edt = $('#char-password'); if (true) edt.attr('type', 'password'); else edt.attr('type', 'text'); "></b><br>
		<!-- <button class="btn btn-info btn-xs" title="Показать пароль" onclick="">+</button> -->
		<input type="password" id="char-password" value="<?php echo $model->pass; ?>"><br>
		<b>Персонаж</b><br>
		<?php echo $model->username_old; ?>
	</div>
</div>

	<div class="pull-right">
		<b>Конфигурация</b><br>
		<?php echo CHtml::dropDownList('tconfig', '', $tconfigs, array( // Store active element in the cookie, TODO
			'style' => 'width: 200px;',
		)); ?>
	</div>

	<div class="clear">lua-dump properties...</div>

</div>

<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'type' => 'horizontal',
	'id' => 'create-char-from',
)); ?>

	<?php echo $form->hiddenField($model, 'id'); ?>

	<div>
		<?php $this->widget('application.components.widgets.TransferOptionsWidget', array(
				'model' => $model,
				'form' => $form,
				'options' => $model->getTransferOptionsToUser(),
				'readonly' => true,
			));
		?>
	</div>

	<div class="pull-right" style="height: 1em;">
		Если опция недоступна значит она отключена в <a href="<?php echo Yii::app()->createUrl('/configs/toptions'); ?>">глобальных настройках.</a>
	</div>

	<div class="form-actions">
		<img id="create-char-wait" src="<?php echo Yii::app()->request->baseUrl ?>/images/wait32.gif" style="visibility: hidden;">
		<?php $this->widget('booster.widgets.TbButton', array(
				'buttonType' => 'ajaxButton',
				'context' => 'primary',
				'label' => 'Создать',
				'url' => $this->createUrl('char', array('id' => $model->id)),
				'ajaxOptions' => array(
					'type' => 'POST',
					'beforeSend' => 'function() { OnBeforeCreateCharClick(this); }',
					'success' => 'function(data) { OnCreateCharClick(data); }',
				),
				'htmlOptions' => array(
					'id' => 'btn-create-char',
				),
				'icon' => 'plane',
			)); ?>

		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'link',
			'label' => 'Отмена',
			'icon' => 'ban-circle',
			'url' => $this->createUrl('/transfers'),
			'htmlOptions' => array('id' => 'btn-create-char-cancel'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
<?php unset($form); ?>


<ul class="nav nav-tabs" id="run-tabs">
	<li><a href="#tab-sql" data-toggle="tab">SQL</a></li>
	<li><a href="#tab-sql-execute" data-toggle="tab">Execute SQL</a></li>
	<li><a href="#tab-warnings" data-toggle="tab">Warnings (0)</a></li>
	<li class="active"><a href="#tab-errors" data-toggle="tab">Errors (0)</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane" id="tab-sql">
		<h3>SQL скрипт персонажа</h3>
		<pre id="create-char-sql"><?php echo $sql; ?></pre>
	</div>
	<div class="tab-pane" id="tab-sql-execute">
		<h3>Результат выполнения запросов к базе данных</h3>

		<?php if ($queriesCount > 0): ?>
			<div id="run-queries-table">
			<?php for ($i = 0; $i < $queriesCount; ++$i): ?>
<?php
				if (isset($queries[$i])) {
					$query = $queries[$i];
					$classStatus = 'query-res-success';
				}
				else {
					$query = array('query'=>'', 'status'=>'&nbsp;');
					$classStatus = '';
				}
?>
				<span class="query-res <?php echo $classStatus; ?>" title="<?php echo $query['query']; ?>"><?php echo $query['status'] ?></span>
			<?php endfor; ?>
			</div>
		<?php else: ?>
			<div id="run-queries-table" style="display: none;"></div>
		<?php endif; ?>

	</div>
	<div class="tab-pane" id="tab-warnings">
		<h3>Предупреждения</h3>

	</div>
	<div class="tab-pane active" id="tab-errors">
		<h3>Ошибки</h3>

	</div>
</div>


<?php $queriesContent = ''; ?>




<div style="margin: 30px 0 10px 30px;">
<?php $this->widget('booster.widgets.TbButton', array(
	'buttonType' => 'link',
	'context' => 'success',
	'label' => 'К заявкам',
	'url' => $this->createUrl('/transfers'),
	'htmlOptions' => array('id' => 'btn-create-char-success', 'style' => 'display: none;'),
	'icon' => 'list',
)); ?>
</div>




<!-- Lua dump dialog, TODO -->
<div class="modal fade" id="lua-dump-dialog" role="dialog" tabindex="-1" aria-hidden="true" aria-labelledby="lua-dump-dialog-title">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="lua-dump-dialog-title">Lua dump from database</h4>
			</div>
			<div class="modal-body">
				<pre id="lua-dump-dialog-content" style="height: 500px;"></pre>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
			</div>
		</div>
	</div>
</div>
