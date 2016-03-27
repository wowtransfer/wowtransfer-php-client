<?php

class WebApplicationEndBehavior extends CBehavior
{
	private $_endName; // backend and front end parts

	public function getEndName()
	{
		return $this->_endName;
	}

	/**
	 * Run application
	 */
	public function runEnd($name)
	{
		$this->_endName = $name;

		$this->onModuleCreate = array($this, 'changeModulePaths');
		$this->onModuleCreate(new CEvent($this->owner));

		$this->owner->run();
	}

	/**
	 *
	 */
	public function onModuleCreate($event)
	{
		$this->raiseEvent('onModuleCreate', $event);
	}

	/**
	 * 
	 */
	protected function changeModulePaths($event)
	{
		if (!empty($this->_endName))
		{
			$event->sender->controllerPath .= DIRECTORY_SEPARATOR . $this->_endName;
			$event->sender->viewPath .= DIRECTORY_SEPARATOR . $this->_endName;
		}
	}
}