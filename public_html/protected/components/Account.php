<?php

abstract class Account
{
	public $id;
	public $username;
	public $password;
	public $online;

	/**
	 * Authenticate by username and password
	 *
	 * @param $username account's name
	 * @param $password account's password
	 * @return boolean Authenticate result
	 */
	public abstract function authenticate($username, $password);
}