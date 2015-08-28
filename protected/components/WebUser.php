<?php

class WebUser extends CWebUser
{
	/**
	 * @var string
	 */
	protected $lang;

	/**
	 * @var array
	 */
	private $availableLanguages = ['ru', 'en'];

	/**
	 * @return string
	 */
	function getRole()
	{
		return $this->getState('role', 'guest');
	}

	/**
	 * @return boolean
	 */
	public function isAdmin()
	{
		return $this->getRole() === 'admin';
	}

	/**
	 * @return boolean
	 */
	public function isModerator()
	{
		return $this->getRole() === 'moderator';
	}

	/**
	 * @return string
	 */
	public function getLang() {
		if ($this->lang === null) {
			$langCookie = Yii::app()->request->cookies['lang'];
			if (is_object($langCookie)) {
				$this->lang = $langCookie->value;
			}
			if (empty($this->lang)) {
				$this->lang = 'ru';
			}
			if (!in_array($this->lang, $this->availableLanguages)) {
				$this->lang = 'ru';
			}
		}
		return $this->lang;
	}

	/**
	 * @param string $lang
	 * @return \WebUser
	 */
	public function setLang($lang) {
		if (!in_array($this->lang, $this->availableLanguages)) {
			$lang = 'ru';
		}
		$cookie = new CHttpCookie('lang', $lang);
		$cookie->path = '/chdphp';
		$cookie->expire = time() + 3600 * 30;
		Yii::app()->request->cookies['lang'] = $cookie;

		return $this;
	}
}