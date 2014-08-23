<?php

class AccountTrinity extends Account
{
	public function authenticate($username, $password)
	{
		$command = Yii::app()->db->createCommand('SELECT id, sha_pass_hash, online FROM auth.account WHERE username=:username LIMIT 1');
		$command->bindValue(':username', $username);
		$result = $command->queryRow();
		if ($result === false)
			return false;

		$hash = sha1(strtoupper($username) . ':' . strtoupper($password));
		if ($hash !== $result['sha_pass_hash'])
			return false;

		$this->username = $username;
		$this->password = $password;
		$this->id       = $result['id'];
		$this->online   = $result['online'];

		return true;
	}
}