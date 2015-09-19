<?php

class WowtransferUI extends Wowtransfer
{
	/**
	 * @var array
	 */
	private static $_cores;

	/**
	 * @var array Id => Name
	 */
	protected static $tconfigsPair;

	public function __construct() {
		parent::__construct();

		$this->setAccessToken(Yii::app()->params['accessToken']);
		$this->setBaseUrl(Yii::app()->params['apiBaseUrl']);
	}

	/**
	 * @return array Associative array kind of 'id' => 'name'
	 */
	public function getTransferConfigsPair() {
		if ($this->tconfigsPair === null) {
			$this->tconfigsPair = [];
			foreach (parent::getTransferConfigs() as $config) {
				$this->tconfigsPair[$config['id']] = $config['name'];
			}
		}
		return $this->tconfigsPair;
	}

	/**
	 * @param integer $type
	 * @return string
	 */
	public static function getTransferConfigType($type) {
		if ($type === self::TCONFIG_TYPE_PRIVATE) {
			return 'private';
		}
		if ($type === self::TCONFIG_TYPE_PUBLIC) {
			return 'public';
		}
		return '';
	}

	/**
	 * @return array Associative array kind of 'name' => 'title'
	 */
	public function getCores() {
		$cores = array();

		if (self::$_cores === null) {
			self::$_cores = parent::getCores();
		}
		if (is_array(self::$_cores)) {
			foreach (self::$_cores as $core) {
				$cores[$core['name']] = $core['title'];
			}
		}

		return $cores;
	}

	/**
	 * @return array
	 *
	 * incluing empty item [''] = ''
	 */
	public function getWowServers() {
		$serversSource = parent::getWowServers();

		$servers = array('' => '');
		if (is_array($serversSource)) {
			for ($i = 0; $i < count($serversSource); ++$i) {
				$server = $serversSource[$i];
				$servers[$server['site_url']] = $server['title'];
			}
		}
		asort($servers);

		return $servers;
	}
}