<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_ACCOUNT_ONLINE = 8;

	private $_id;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		switch (Yii::app()->params['core']) // TODO: use pattern
		{
			case 'trinity':
				$account = new AccountTrinity();
				break;
			case 'cmangos':
				$account = new AccountCMangos();
				break;
			default:
				throw new Exception('Unknown core. See `params` section in main.php file.');
		}

		if (!$account->authenticate($this->username, $this->password))
		{
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
		elseif ($account->online)
		{
			$this->errorCode = self::ERROR_ACCOUNT_ONLINE;
		}
		else
		{
			$this->_id = $account->id;
			$this->errorCode = self::ERROR_NONE;
		}

		return $this->errorCode == self::ERROR_NONE;
	}

	public function getId()
	{
		return $this->_id;
	}
}