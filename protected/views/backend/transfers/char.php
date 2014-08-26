<?php
/* @var $this TransfersController frontend */
/* @var $model ChdTransfer model */
?>

<?php if ($model->char_guid > 0): ?>
	<div class="alert alert-info">
		Персонаж уде создан, GUID = <b><?php echo $model->char_guid; ?></b>.
	</div>
<?php return; endif; ?>

<div style="float: right; width: 100px; border: 1px solid blue;">
Конфигурация...
</div>

<h1>Создание персонажа по заявке #<?php echo $model->id; ?></h1>

<div style="float: right; border: 1px solid blue; width: 260px; height: 120px;">
<a href="#">Clear character's data by GUID and ID</a> <span style="color: green;">safe</span><br>
<a href="#">Clear character's data by GUID</a> <span style="color: orange;">unsafe</span><br>
<a href="#">Show character's info by GUID and ID</a><br>
<a href="#">View lua-dump</a><br>
<a href="#">View decrypted lua-dump</a><br>
<a href="#">Список заявок</a><br>
<a href="#">Управление заявками</a>
</div>

<div style="margin: 5px 0; border: 1px solid blue; width: 430px; height: 140px;">

<div>
<div style="float: left; padding: 3px;">
	<b>Создана</b><br> <?php echo $model->create_transfer_date; ?><br>
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
	<b>Пароль</b><br>
	*********<br>
	<b>Персонаж</b><br>
	<?php echo $model->username_old; ?>
</div>

</div>

<div class="clear">lua-dump properties</div>

</div>

<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array('id' => 'create-char-from')); ?>

<?php echo $form->hiddenField($model, 'id'); ?>

<fieldset>
	<legend><?php echo $form->labelEx($model,'transferOptions'); ?></legend>

		<div class="row">
			<div>
				<?php echo $form->error($model,'transferOptions'); ?>
			</div>
			<?php echo $form->checkBoxList($model, 'transferOptions', $model->getTransferOptionsToUser(),
				array(
					'checkAll' => 'Выбрать все',
					'checkAllLast' => true,
					'template' => '<span class="toptions">{input} {label}</span>',
					'separator' => '',
					'class' => 'inline-chb',
				)
			); ?>
		</div>
	</fieldset>

<div style="height: 1em;">
<div style="float: right;">
Если опция недоступна значит она отключена в глобальных настройках.
</div>
</div>


<div class="row submit">
    <?php echo CHtml::ajaxSubmitButton('Создать', Yii::app()->request->requestUri, array(
		'success' => 'js:function(data){ $("#sql-content").text(data); }',
	)); ?> Create character by AJAX
</div>

<?php $this->endWidget(); ?>
</div>

<p>
Retrieve SQL... errors
</p>

<p>
Run SQL... first error
</p>

<pre id="sql-content" style="border: 1px solid blue; width: 400px; height: 100px;"></pre>

<div id="sql-run-result" style="border: 1px solid blue; width: 400px; height: 100px;">
Result table
</div>


results:
<div id="dump-lua" style="border: 1px solid blue; width: 400px; height: 100px;">

<div>
<span style="float: left;">index (1, 2, ...)</span><br>
query (maximum 255 characters)<br>
status
</div>


</div>
