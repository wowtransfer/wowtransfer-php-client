<?php

class BaseController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = 'main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();
	/**
	 * Description in meta tag
	 */
	public $description = '';
	/**
	 * Keywords in meta tag
	 */
	public $keywords = '';

	/**
	 * @var array
	 */
	protected $asideBlocks = array();

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error)
		{
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function init()
	{
		return parent::init();
	}

	/**
	 * @param string $block
	 */
	public function addAsideBlockToColumn2($block) {
		$this->asideBlocks[] = $block;
	}
}