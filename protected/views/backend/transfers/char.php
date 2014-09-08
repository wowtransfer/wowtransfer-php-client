<?php
/* @var $this TransfersController frontend */
/* @var $model ChdTransfer model */
/* @var $retrieveSqlError */
/* @var $runSqlError */
/* @var $queries */
/* @var $queriesCount */
/* @var $sql */
?>

<div style="float: right; width: 100px; border: 1px solid blue;">
Конфигурация...
</div>

<h1>Создание персонажа по заявке #<?php echo $model->id; ?></h1>

<div style="float: right; width: 260px; height: 120px;">
<a href="#">Clear character's data by GUID and ID</a> <span style="color: green;">safe</span><br>
<a href="#">Clear character's data by GUID</a> <span style="color: orange;">unsafe</span><br>
<a href="#">Show character's info by GUID and ID</a><br>
<a href="#">View lua-dump</a><br>
<a href="#">View decrypted lua-dump</a><br>
<a href="<?php echo $this->createUrl('/transfers/index') ?>">Список заявок</a><br>
<a href="<?php echo $this->createUrl('/transfers/admin') ?>">Управление заявками</a>
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

<div class="clear">lua-dump properties...</div>

</div>

<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array('id' => 'create-char-from')); ?>

<?php echo $form->hiddenField($model, 'id'); ?>

<fieldset>
	<legend><?php echo $form->labelEx($model, 'transferOptions'); ?></legend>

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
	<img id="create-char-wait" src="<?php echo Yii::app()->request->baseUrl ?>/images/wait32.gif" style="visibility: hidden;">
    <?php //echo CHtml::submitButton('Создать', Yii::app()->request->requestUri, array(
		echo CHtml::submitButton('Create', array(
		'beforeSend' => 'function() { $("#create-char-wait").css("visibility", "visible"); $("#sql-content").text(""); }',
		'success' => 'js: function(data) { OnCreateCharClick(data); }',
		'title' => 'Create character',
	)); ?>
	<?php echo CHtml::link('Cancel', Yii::app()->request->ScriptUrl . '/transfers'); ?>
</div>

<?php $this->endWidget(); ?>
</div>

<?php if (empty($createCharError)): ?>
	<div id="create-char-error" class="flash-error" style="display: none;"></div>
<?php else: ?>
	<div id="create-char-error" class="flash-error"><?php echo $createCharError; ?></div>
<?php endif; ?>

<?php $queriesContent = ''; ?>

<div id="run-queries-table" style="border: 1px solid blue; margin: 0; padding: 0 2px 2px 0;">
<?php for ($i = 0; $i < $queriesCount; ++$i): ?>
	<?php
		if (isset($queries[$i])):
			$query = $queries[$i];
			$classStatus = 'query-res-success';
		else:
			$query = array('query'=>'', 'status'=>'&nbsp;');
			$classStatus = '';
		endif;
	?>
	<span class="query-res <?php echo $classStatus?>" title="<?php echo $query['query']; ?>"><?php echo $query['status'] ?></span>
<?php endfor; ?>
</div>

<pre id="sql-content" style="border: 1px solid blue; height: 300px; overflow: auto;"><?php echo $sql; ?></pre>
