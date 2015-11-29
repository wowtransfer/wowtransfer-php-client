<?php

class TransferOptionsWidget extends CWidget
{
	public $form;
	public $model;
	public $options;
	public $readonly = true;

	public function init()
	{
		parent::init();
	}

	public function run()
	{
		$this->render('TransferOptionsWidget', [
			'model'         => $this->model,
			'options'       => $this->options,
			'form'          => $this->form,
			'readonly'      => $this->readonly,
			'optionsGlobal' => TransferOptions::getOptions(),
		]);
	}
}