<?php

class WowtransferUI extends Wowtransfer
{
	/**
	 * @var array Name => Title
	 */
	protected $coresPair;

	/**
	 * @var array Id => Name
	 */
	protected static $tconfigsPair;

	/**
	 * @var array Url => Name
	 */
	protected $wowServersPair;

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
	public function getCoresPair() {
		if ($this->coresPair === null) {
			$this->coresPair = [];
			foreach (parent::getCores() as $core) {
				$this->coresPair[$core['name']] = $core['title'];
			}
		}
		return $this->coresPair;
	}

	/**
	 * @return array
	 *
	 * incluing empty item [''] = ''
	 */
	public function getWowServersPair() {
		if ($this->wowServersPair === null) {
			$this->wowServersPair = [];
			foreach (parent::getWowServers() as $server) {
				$this->wowServersPair[$server->getSite()] = $server->getName();
			}
			asort($this->wowServersPair);
		}
		return $this->wowServersPair;
	}
}