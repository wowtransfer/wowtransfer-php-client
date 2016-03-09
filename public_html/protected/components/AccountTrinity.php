<?php

class AccountTrinity extends Account
{
	/**
	 * @param string $username
	 * @param string $password
	 * @return boolean
	 */
	public function authenticate($username, $password) {
		$command = Yii::app()->db->createCommand();
		$row = $command
			->select('id, sha_pass_hash, online')
			->from('auth.account')
			->where('username=:username', array(':username' => $username))
			->limit(1)
			->queryRow();

		if ($row) {
			// The trinity's console write password in uppercase
			$hash = sha1(strtoupper($username) . ':' . strtoupper($password));
			if (!strcasecmp($hash, $row['sha_pass_hash'])) {
				$this->username = $username;
				$this->password = $password;
				$this->id       = $row['id'];
				$this->online   = $row['online'];
				return true;
			}
		}

		return false;
	}
}