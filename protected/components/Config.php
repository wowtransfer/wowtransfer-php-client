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
	 * @var array
	 */
	protected $transferOptions;

	/**
	 * @var int[]
	 */
	protected $excludeRealms;

	/**
	 * @var string
	 */
	protected $authDb;

	/**
	 * @var string
	 */
	protected $worldDb;

	private function __construct() {
		$this->configDir = Yii::getPathOfAlias('application') . DIRECTORY_SEPARATOR . 'config';

		// app
		$appSettins = require $this->configDir . DIRECTORY_SEPARATOR . 'app.php';
		$appLocalFilePath = $this->configDir . DIRECTORY_SEPARATOR . 'app-local.php';
		if (file_exists($appLocalFilePath)) {
			$appSettins = array_merge($appSettins, require $appLocalFilePath);
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
		$this->authDb = $appSettins['authDb'];
		$this->worldDb = $appSettins['worldDb'];

		// remote servers
		$remoteServerLocalFileFile = $this->configDir . DIRECTORY_SEPARATOR . 'remote-servers-local.php';
		$this->excludeRealms = require $remoteServerLocalFileFile;

		// service
		$serviceSettins = require $this->configDir . DIRECTORY_SEPARATOR . 'service.php';
		$serviceLocalFilePath = $this->configDir . DIRECTORY_SEPARATOR . 'service-local.php';
		if (file_exists($serviceLocalFilePath)) {
			$serviceSettins = array_merge($serviceSettins, require $serviceLocalFilePath);
		}
		$this->apiBaseUrl = $serviceSettins['apiBaseUrl'];
		$this->accessToken = $serviceSettins['accessToken'];
		$this->serviceUsername = $serviceSettins['serviceUsername'];

		// toptions
		$this->transferOptions = require $this->configDir . DIRECTORY_SEPARATOR . 'toptions.php';
		$transferOptionsLocalFilePath = $this->configDir . DIRECTORY_SEPARATOR . 'toptions-local.php';
		if (file_exists($transferOptionsLocalFilePath)) {
			$this->transferOptions = array_merge($this->transferOptions, require $transferOptionsLocalFilePath);
		}

		// db
		// parse connecting string...
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

	/**
	 * @return array
	 */
	public function getTransferOptions() {
		return $this->transferOptions;
	}

	/**
	 * @return string
	 */
	public function getAuthDb() {
		return $this->authDb;
	}

	/**
	 * @return string
	 */
	public function getWorldDb() {
		return $this->worldDb;
	}
}
