<?php

/**
 * Wrapper about an local parameters, readonly
 */
class Config
{
	/**
	 * @var Config
	 */
	private static $instance;

	/**
	 * @var string
	 */
	protected $configDir;

	/**
	 * @var string
	 */
	protected $version;

	/**
	 * @var string
	 */
	protected $date;

	/**
	 * @var string[]
	 */
	protected $admins;

	/**
	 * @var boolean
	 */
	protected $onlyCheckedServers;

	/**
	 * @var string
	 */
	protected $core;

	/**
	 * @var string
	 */
	protected $emailAdmin;

	/**
	 * @var int
	 */
	protected $maxTransfersCount;

	/**
	 * @var int
	 */
	protected $maxAccountCharsCount;

	/**
	 * @var string[]
	 */
	protected $moders;

	/**
	 * @var string
	 */
	protected $siteUrl;

	/**
	 * @var string
	 */
	protected $transferTable;

	/**
	 * @var int
	 */
	protected $yiiTraceLevel;

	/**
	 * @var boolean
	 */
	protected $yiiDebug;


	/**
	 * @var string
	 */
	protected $apiBaseUrl;

	/**
	 * @var string
	 */
	protected $serviceUsername;

	/**
	 * @var string
	 */
	protected $accessToken;

	/**
	 * @var int[]
	 */
	protected $excludeRealms;

	private function __construct() {
		$this->configDir = Yii::getPathOfAlias('application') . '/config';

		// app
		$appSettins = require $this->configDir . '/app.php';
		if (file_exists($this->configDir . '/app-local.php')) {
			$appSettins = array_merge($appSettins, require $this->configDir . '/app-local.php');
		}
		$this->version = $appSettins['version'];
		$this->date = $appSettins['date'];
		$this->admins = $appSettins['admins'];
		$this->onlyCheckedServers = $appSettins['onlyCheckedServers'];
		$this->core = $appSettins['core'];
		$this->emailAdmin = $appSettins['emailAdmin'];
		$this->maxTransfersCount = $appSettins['maxTransfersCount'];
		$this->maxAccountCharsCount = $appSettins['maxAccountCharsCount'];
		$this->moders = $appSettins['moders'];
		$this->siteUrl = $appSettins['siteUrl'];
		$this->transferTable = $appSettins['transferTable'];
		$this->yiiDebug = $appSettins['yiiDebug'];
		$this->yiiTraceLevel = $appSettins['yiiTraceLevel'];

		// remote servers
		$this->excludeRealms = require $this->configDir . '/remote-servers-local.php';

		// service
		$serviceSettins = require $this->configDir . '/service.php';
		if (file_exists($this->configDir . '/service-local.php')) {
			$serviceSettins = array_merge($serviceSettins, require $this->configDir . '/service-local.php');
		}
		$this->apiBaseUrl = $serviceSettins['apiBaseUrl'];
		$this->accessToken = $serviceSettins['accessToken'];
		$this->serviceUsername = $serviceSettins['serviceUsername'];

		// toptions

	}

	/**
	 * @return Config
	 */
	public static function getInstance() {
		if (self::$instance === null) {
			self::$instance = new Config();
		}
		return self::$instance;
	}

	/**
	 * @return string
	 */
	public function getVersion() {
		return $this->version;
	}

	/**
	 * @return string
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * @return string[]
	 */
	public function getAdmins() {
		return $this->admins;
	}

	/**
	 * @return boolean
	 */
	public function getOnlyCheckedServers() {
		return $this->onlyCheckedServers;
	}

	/**
	 * @return string
	 */
	public function getCore() {
		return $this->core;
	}

	/**
	 * @return string
	 */
	public function getEmailAdmin() {
		return $this->emailAdmin;
	}

	/**
	 * @return int
	 */
	public function getMaxTransfersCount() {
		return $this->maxTransfersCount;
	}

	/**
	 * @return int
	 */
	public function getMaxAccountCharsCount() {
		return $this->maxAccountCharsCount;
	}

	/**
	 * @return string[]
	 */
	public function getModers() {
		return $this->moders;
	}

	/**
	 * @return string
	 */
	public function getSiteUrl() {
		return $this->siteUrl;
	}

	/**
	 * @return string
	 */
	public function getTransferTable() {
		return $this->transferTable;
	}

	/**
	 * @return int
	 */
	public function getYiiTraceLevel() {
		return $this->yiiTraceLevel;
	}

	/**
	 * @return boolean
	 */
	public function getYiiDebug() {
		return $this->yiiDebug;
	}

	/**
	 * @return string
	 */
	public function getApiBaseUrl() {
		return $this->apiBaseUrl;
	}

	/**
	 * @return string
	 */
	public function getServiceUsername() {
		return $this->serviceUsername;
	}

	/**
	 * @return string
	 */
	public function getAccessToken() {
		return $this->accessToken;
	}

	/**
	 * @return int[]
	 */
	public function getExcludeRealms() {
		return $this->excludeRealms;
	}
}
