<?php

class WebUser extends CWebUser
{
	private $_model = null;

	function getRole()
	{
		return $this->getState('role', 'guest');
	}

	public function isAdmin()
	{
		return $this->getRole() === 'admin';
	}

	public function isModerator()
	{
		return $this->getRole() === 'moderator';
	}
}