<?
/* @var BackendController $this */
/* @var array $tconfig */
?>

<?= TbHtml::beginFormTb(TbHtml::FORM_LAYOUT_VERTICAL); ?>

<?
	echo TbHtml::textFieldControlGroup('name', $tconfig['name'], array('label' => Yii::t('app', 'Name'), 'readonly' => 1));
	echo TbHtml::textFieldControlGroup('descr', $tconfig['descr'], array('label' => Yii::t('app', 'Description'), 'readonly' => 1));
	echo TbHtml::textFieldControlGroup('update_date', $tconfig['update_date'], array('label' => Yii::t('app', 'Change date'), 'readonly' => 1));
	echo TbHtml::textFieldControlGroup('type', WowtransferUI::getTransferConfigType($tconfig['type']), array('label' => 'Тип', 'readonly' => 1));
?>

<?= TbHtml::textAreaControlGroup('body', $tconfig['body'], array(
	'label' => Yii::t('app', 'Content'),
	'readonly' => 1,
	'rows' => 20,
)); ?>

<div class="form-actions">
	<a class="btn btn-default" href="<?= $this->createUrl('/tconfigs'); ?>">
		<?= Yii::t('app', 'Cancel') ?>
	</a>
</div>

<?= TbHtml::endForm(); ?>