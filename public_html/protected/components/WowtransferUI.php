<?php

class WowtransferUI extends \Wowtransfer\Service
{
	/**
	 * @var array Name => Title
	 */
	protected $coresPair;

	/**
	 * @var array Id => Name
	 */
	protected $tconfigsPair;

	/**
	 * @var array Url => Name
	 */
	protected $wowServersPair;

    /**
	 * @var string[]
	 */
	protected $wowserversSites;

	public function __construct() {
        $accessToken = Config::getInstance()->getAccessToken();
		parent::__construct($accessToken);

		$this->setBaseUrl(Config::getInstance()->getApiBaseUrl());
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
	 */
	public function getWowServersPair() {
		if ($this->wowServersPair === null) {
			$this->wowServersPair = [];
			$realmIds = Config::getInstance()->getExcludeRealms();
			foreach (parent::getWowServers() as $server) {
				$include = false;
				foreach ($server->getRealms() as $realm) {
					if (!in_array($realm->getId(), $realmIds)) {
						$include = true;
						break;
					}
				}
				if ($include) {
					$this->wowServersPair[$server->getSite()] = $server->getSite();
				}
			}
			asort($this->wowServersPair);
		}
		return $this->wowServersPair;
	}

    /**
	 * @return array
	 */
	public function getWowServersSites() {
		if ($this->wowserversSites === null) {
            $this->wowserversSites = [];
			foreach (parent::getWowServers() as $server) {
				$this->wowserversSites[] = $server->getSite();
			}
		}
		return $this->wowserversSites;
	}
}