<?php
/* @var BackendController $this */
/* @var array $tconfig */
?>

<?php echo TbHtml::beginFormTb(TbHtml::FORM_LAYOUT_VERTICAL); ?>

<?php
	echo TbHtml::textFieldControlGroup('name', $tconfig['name'], array('label' => 'Название', 'readonly' => 1));
	echo TbHtml::textFieldControlGroup('descr', $tconfig['descr'], array('label' => 'Описание', 'readonly' => 1));
	echo TbHtml::textFieldControlGroup('update_date', $tconfig['update_date'], array('label' => 'Дата изменения', 'readonly' => 1));
	echo TbHtml::textFieldControlGroup('type', WowtransferUI::getTransferConfigType($tconfig['type']), array('label' => 'Тип', 'readonly' => 1));
?>

<?php echo TbHtml::textAreaControlGroup('body', $tconfig['body'], array(
	'label' => 'Содержание',
	'readonly' => 1,
	'rows' => 20,
)); ?>

<div class="form-actions">
	<a class="btn btn-default" href="<?php echo $this->createUrl('/tconfigs'); ?>">Отмена</a>
</div>

<?php echo TbHtml::endForm(); ?>