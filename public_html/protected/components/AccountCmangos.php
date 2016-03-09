<?php

class AccountCmangos extends Account
{
	public function authenticate($username, $password)
	{
		return false;
	}
}
