<?php

/**
 * Main class of wowtransfer.com service
 */
class Wowtransfer
{
	const TCONFIG_TYPE_PRIVATE = 0;
	const TCONFIG_TYPE_PUBLIC  = 1;

	const LANG_RU = 'ru';
	const LANG_EN = 'en';

	const LUA_MIME_TYPE = 'application/x-lua';

	/**
	 * @var resource Curl handle
	 */
	private $_ch;

	/**
	 * @var string API Base url, without / on end
	 */
	protected $serviceBaseUrl;

	/**
	 * @var string
	 */
	protected $accessToken;

	/**
	 * @var boolean
	 */
	protected $useCache;

	/**
	 * @var int
	 */
	protected $lastHttpStatus;

	/**
	 * @var string
	 */
	protected $lastHttpResponse;

	/**
	 * @var string
	 */
	protected $lastError;

	/**
	 * @var string
	 */
	protected $lang;

	/**
	 * @var array
	 */
	protected $transferConfigs;

	/**
	 * @var array
	 */
	protected $cores;

	/**
	 * @var array
	 */
	protected $wowServers;

	/**
	 * @var WowtransferApplication[]
	 */
	protected $applications;

	public function __construct()
	{
		$this->_ch = curl_init();
		curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->_ch, CURLOPT_FOLLOWLOCATION, 1);
	}

	public function __destruct()
	{
		curl_close($this->_ch);
	}

	/**
	 * @return string
	 */
	public function getLang() {
		return $this->lang;
	}

	/**
	 * @param string $lang
	 * @return \Wowtransfer
	 */
	public function setLang($lang) {
		$this->lang = $lang;
		return $this;
	}

	/**
	 * @return string
	 */
	public static function getDefaultBaseUrl() {
		return 'http://wowtransfer.com/api/v1';
	}

	/**
	 * @return string
	 */
	public function getLastHttpStatus() {
		return $this->lastHttpStatus;
	}

	/**
	 * @return string
	 */
	public function getLastHttpResponse() {
		return $this->lastHttpResponse;
	}

	/**
	 * @return string
	 */
	public function getLastError() {
		return $this->lastError;
	}

	/**
	 * @param string $lastError
	 * @return \Wowtransfer
	 */
	protected function setLastError($lastError) {
		$this->lastError = $lastError;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function isUseCache() {
		return $this->useCache;
	}

	/**
	 * @param type $useCache
	 * @return \Wowtransfer
	 */
	public function setUseCache($useCache) {
		$this->useCache = $useCache;
		return $this;
	}

	/**
	 * @param string $accessToken
	 * @return Wowtransfer
	 */
	public function setAccessToken($accessToken) {
		$this->accessToken = $accessToken;
		return $this;
	}

	/**
	 * @return string
	 */
	private function getAccessToken() {
		return $this->accessToken;
	}

	/**
	 * @param string $url
	 * @return Wowtransfer
	 */
	public function setBaseUrl($url) {
		if (empty($url)) {
			throw new \exception('Empty base url');
		}

		if ($url[strlen($url) - 1] === '/') {
			$url = substr($url, 0, -1);
		}
		$this->serviceBaseUrl = $url;

		return $this;
	}

	/**
	 * @return string API Base url, without '/' on end
	 */
	public function getBaseUrl() {
		return $this->serviceBaseUrl;
	}

	/**
	 * @return array
	 * @todo loading from wowtransfer.com with locale
	 */
	public static function getDumpFields() {
		return [
			'achievement' => [],
			'action'      => [],
			'bind'        => [],
			'bag'         => [],
			'bank'        => [],
			'criterias'   => [],
			'critter'     => [],
			'currency'    => [],
			'equipment'   => ['disabled' => 1],
			'glyph'       => [],
			'inventory'   => [],
			'mount'       => [],
			'pmacro'      => ['disabled' => 1],
			'quest'       => [],
			'questlog'    => [],
			'reputation'  => [],
			'skill'       => [],
			'skillspell'  => [],
			'spell'       => [],
			'statistic'   => [],
			'talent'      => [],
			'taxi'        => [],
			'title'       => [],
		];
	}

	/**
	 * @param string $dumpLua
	 * @param array $fields
	 * @return boolean|array
	 */
	public function getDump($dumpLua, $fields = []) {
		if (empty($dumpLua)) {
			return false;
		}
		$filePath = sys_get_temp_dir() . '/' . uniqid() . '.lua';
		$file = fopen($filePath, 'w');
		if (!$file) {
			$this->lastError = 'fopen() failed! file: ' . $filePath;
			return false;
		}
		fwrite($file, $dumpLua);
		fclose($file);

		$dumpFile = new CURLFile($filePath, self::LUA_MIME_TYPE, 'chardumps.lua');

		$ch = $this->_ch;
		curl_setopt($ch, CURLOPT_URL, $this->getApiUrl('/dumps/fields/'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: multipart/form-data']);
		curl_setopt($ch, CURLOPT_POST, 1);
		$postfields = [
			'dump_lua'     => $dumpFile,
			'fields'       => implode(',', $fields),
		];
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);

		$this->lastHttpResponse = curl_exec($ch);
		$this->lastHttpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		unlink($filePath);

		if ($this->lastHttpStatus != 200) {
			$response = json_decode($this->lastHttpResponse, true);
			if ($response) {
				$this->lastError = isset($response['error_message']) ? $response['error_message'] : 'Error';
			}
			else {
				$this->lastError = 'Erorr (' . $this->lastHttpStatus . ')';
			}
			return false;
		}

		return json_decode($this->lastHttpResponse, true);
	}

	/**
	 * @return array
	 */
	public static function getDumpFieldsNames() {
		return array_keys(self::getDumpFields());
	}

	/**
	 * @return string Actual version of API
	 */
	public function getApiVersion() {
		return '1.0';
	}

	/**
	 * @return array|false
	 * @throws Exception
	 */
	public function getCores() {
		if ($this->cores === null) {
			$defaultValue = [];
			$ch = $this->_ch;
			curl_setopt($ch, CURLOPT_URL, $this->getApiUrl('/cores'));
			$this->lastHttpResponse = curl_exec($ch);
			$this->lastHttpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			$this->cores = [];
			$cores = json_decode($this->lastHttpResponse, true);
			if (!$cores) {
				$this->lastError = "Could't get cores from service";
			}
			elseif ($this->lastHttpStatus !== 200) {
				$this->lastError = isset($cores['error_message']) ? $cores['error_message'] : 'Error ' . $this->lastHttpStatus;
			}
			else {
				$this->cores = $cores;
			}
		}
		return $this->cores;
	}

	/**
	 * @return array
	 */
	public function getTransferConfigs() {
		if ($this->transferConfigs === null) {
			$ch = $this->_ch;
			$url = $this->getApiUrl('/tconfigs' . '?access_token=' . $this->getAccessToken());
			curl_setopt($ch, CURLOPT_URL, $url);
			$this->lastHttpResponse = curl_exec($ch);
			$this->lastHttpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			$this->transferConfigs = [];
			$tconfigs = json_decode($this->lastHttpResponse, true);
			if (!is_array($tconfigs)) {
				$this->lastError = "Couldn't get transfer configurations from service";
			}
			elseif ($this->lastHttpStatus !== 200) {
				$this->lastError = isset($tconfigs['error_message']) ? $tconfigs['error_message'] : 'Error ' . $this->lastHttpStatus;
			}
			else {
				$this->transferConfigs = $tconfigs;
			}
		}
		return $this->transferConfigs;
	}

	/**
	 * @param integer $id Identifier of trasnfer configuration
	 * @return array
	 */
	public function getTransferConfig($id) {
		$defaultValue = false;
		$tconfigId = (int)$id;
		$ch = $this->_ch;
		$url = $this->getApiUrl('/user/tconfigs/' . $tconfigId . '?access_token=' . $this->getAccessToken());
		curl_setopt($ch, CURLOPT_URL, $url);
		$this->lastHttpResponse = curl_exec($ch);
		$this->lastHttpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$result = json_decode($this->lastHttpResponse, true);
		if (!$result) {
			$this->lastError = "Could't get transfer configuration #$tconfigId from service";
			return $defaultValue;
		}
		if ($this->lastHttpStatus !== 200) {
			$this->lastError = isset($result['error_message']) ? $result['error_message'] : 'Error ' . $this->lastHttpStatus;
			return $defaultValue;
		}

		return $result;
	}

	/**
	 * Convert lua-dump to sql script
	 *
	 * @param string  $dumpLua        Lua dump
	 * @param integer $accountId      Accounts' identifier
	 * @param strign  $configuration  Name of configuration
	 * @param array   $toptions
	 *
	 * @return string Sql script (200) or error message (501)
	 */
	public function dumpToSql($dumpLua, $accountId, $configuration, $toptions) {
		$defaultValue = '';
		$filePath = sys_get_temp_dir() . '/' . uniqid() . '.lua';
		$file = fopen($filePath, 'w');
		if (!$file) {
			$this->lastError = 'fopen() failed! file: ' . $filePath;
			return $defaultValue;
		}
		fwrite($file, gzencode($dumpLua));
		fclose($file);

		$dumpFile = new CURLFile($filePath, self::LUA_MIME_TYPE, 'chardumps.lua');

		$ch = $this->_ch;
		$postfields = [
			'dump_lua'         => $dumpFile,
			'dump_encode'      => 'gzip',
			'configuration_id' => $configuration,
			'account_id'       => $accountId,
			'access_token'     => $this->getAccessToken(),
			'transfer_options' => implode(';', $toptions),
		];
		curl_setopt_array($ch, [
			CURLOPT_URL         => $this->getApiUrl('/dumps/sql'),
			CURLOPT_HTTPHEADER  => ['Content-type: multipart/form-data'],
			CURLOPT_POST        => 1,
			CURLOPT_POSTFIELDS  => $postfields,
		]);

		$this->lastHttpResponse = curl_exec($ch);
		$this->lastHttpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		unlink($filePath);

		if ($this->lastHttpStatus != 200) {
			$response = json_decode($this->lastHttpResponse, true);
			if ($response) {
				$this->lastError = isset($response['error_message']) ? $response['error_message'] : 'Error';
			}
			else {
				$this->lastError = 'Erorr (' . $this->lastHttpStatus . ')';
			}
			return $defaultValue;
		}

		return $this->lastHttpResponse;
	}

	/**
	 * @return Wowserver[]
	 */
	public function getWowServers() {
		if ($this->wowServers === null) {
			$ch = $this->_ch;
			curl_setopt($ch, CURLOPT_URL, $this->getApiUrl('/wowservers'));
			$this->lastHttpResponse = curl_exec($ch);
			$this->lastHttpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			$wowServers = [];
			$servers = json_decode($this->lastHttpResponse, true);
			if (!$this->lastHttpResponse) {
				$this->lastError = "Couldn't get wowservers from service";
			}
			if ($this->lastHttpStatus !== 200) {
				$this->lastError = isset($servers['error_message']) ? $servers['error_message'] : 'Error ' . $this->lastHttpStatus;
			}
			else {
				foreach ($servers as $server) {
					$wowserver = new Wowserver();
					$wowserver
						->setId($server['id'])
						->setName($server['name'])
						->setDescription($server['description'])
						->setSite($server['site_url']);
					foreach ($server['realms'] as $serverRealm) {
						$realm = new Realm();
						$realm
							->setId($serverRealm['id'])
							->setName($serverRealm['name'])
							->setRate($serverRealm['rate'])
							->setOnlineCount($serverRealm['online_count']);
						$wowserver->addRealm($realm);
					}
					$wowServers[] = $wowserver;
				}
			}
		}
		return $wowServers;
	}

	/**
	 * for example, http://wowtransfer.com/api/v1/dumps/
	 *
	 * @param string $uri Example '/dumps', '/dumps/', 'dumps'
	 *
	 * @return string
	 */
	protected function getApiUrl($uri) {
		if ($uri{0} !== '/') {
			$uri = '/' . $uri;
		}
		$params = '';
		if (($paramPos = strpos($uri, '?')) !== false) {
			$params = substr($uri, $paramPos);
			$uri = substr($uri, 0, $paramPos);
		}
		$url = $this->getBaseUrl() . $uri;
		if ($url{strlen($url) - 1} !== '/') {
			$url .= '/';
		}
		$url .= $params;

		return $url;
	}

	/**
	 * @return WowtransferApplication[]
	 */
	public function getApplications() {
		if ($this->applications === null) {
			$this->applications = [];
			$ch = $this->_ch;
			curl_setopt($ch, CURLOPT_URL, $this->getApiUrl('/apps'));
			$this->lastHttpResponse = curl_exec($ch);
			$this->lastHttpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$result = json_decode($this->lastHttpResponse, true);
			if ($result && $this->lastHttpStatus == 200) {
				foreach ($result as $appItem) {
					$app = new WowtransferApplication($appItem['id_name']);
					$app
						->setId($appItem['id'])
						->setName($appItem['name'])
						->setDescription($appItem['descr'])
						->setDownloadUrl($appItem['download_url'])
						->setUpdatedAt($appItem['updated_at'])
						->setVersion($appItem['version']);
					$this->applications[$appItem['id_name']] = $app;
				}
			}
		}
		return $this->applications;
	}

	/**
	 * @param string $idName
	 * @return WowtransferApplication|false
	 */
	public function getApplication($idName) {
		if (isset($this->applications[$idName])) {
			return $this->applications[$idName];
		}
		$ch = $this->_ch;
		curl_setopt($ch, CURLOPT_URL, $this->getApiUrl('/apps/' . $idName));
		$this->lastHttpResponse = curl_exec($ch);
		$this->lastHttpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$result = json_decode($this->lastHttpResponse, true);

		if (!$result || $this->lastHttpStatus !== 200) {
			return false;
		}
		$app = new WowtransferApplication($idName);
		$app
			->setId($result['id'])
			->setName($result['name'])
			->setDescription($result['descr'])
			->setDownloadUrl($result['download_url'])
			->setUpdatedAt($result['updated_at'])
			->setVersion($result['version']);

		if (!is_array($this->applications)) {
			$this->applications = [];
		}
		$this->applications[$idName] = $app;

		return $app;
	}
}

/**
 * Available application of service
 */
class WowtransferApplication
{
	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $idName;

	/**
	 * @var string
	 */
	private $name;

	/**
	 *
	 * @var string
	 */
	private $version;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var string
	 */
	private $updatedAt;

	/**
	 * @var string
	 */
	private $downloadUrl;

	/**
	 * @var string
	 */
	private $docUrl;

	/**
	 * @param string $idName
	 */
	public function __construct($idName) {
		$this->idName = $idName;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
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
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return string
	 */
	public function getUpdatedAt() {
		return $this->updatedAt;
	}

	/**
	 * @return string
	 */
	public function getDownloadUrl() {
		return $this->downloadUrl;
	}

	/**
	 * @return string
	 */
	public function getDocUrl() {
		return $this->docUrl;
	}

	/**
	 * @param string $name
	 * @return \WowtransferApplication
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @param string $version
	 * @return \WowtransferApplication
	 */
	public function setVersion($version) {
		$this->version = $version;
		return $this;
	}

	/**
	 * @param string $description
	 * @return \WowtransferApplication
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	/**
	 * @param string $updatedAt
	 * @return \WowtransferApplication
	 */
	public function setUpdatedAt($updatedAt) {
		$this->updatedAt = $updatedAt;
		return $this;
	}

	/**
	 * @param string $downloadUrl
	 * @return \WowtransferApplication
	 */
	public function setDownloadUrl($downloadUrl) {
		$this->downloadUrl = $downloadUrl;
		return $this;
	}

	/**
	 * @param string $docUrl
	 * @return \WowtransferApplication
	 */
	public function setDocUrl($docUrl) {
		$this->docUrl = $docUrl;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getIdName() {
		return $this->idName;
	}

	/**
	 * @param int $id
	 * @return \WowtransferApplication
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @param string $idName
	 * @return \WowtransferApplication
	 */
	public function setIdName($idName) {
		$this->idName = $idName;
		return $this;
	}
}

class Wowserver
{
	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var string
	 */
	protected $site;

	/**
	 * @var Realm[]
	 */
	protected $realms = [];

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @return string
	 */
	public function getSite() {
		return $this->site;
	}

	/**
	 * @param int $id
	 * @return \Wowserver
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @param string $name
	 * @return \Wowserver
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @param string $description
	 * @return \Wowserver
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}

	/**
	 * @param string $site
	 * @return \Wowserver
	 */
	public function setSite($site) {
		$this->site = $site;
		return $this;
	}

	/**
	 * @return Realm[]
	 */
	public function getRealms() {
		return $this->realms;
	}

	/**
	 * @param Realm $realm
	 */
	public function addRealm($realm) {
		$this->realms[] = $realm;
	}
}

class Realm
{
	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var int
	 */
	protected $onlineCount;

	/**
	 * @var int
	 */
	protected $rate;

	/**
	 * @var string
	 */
	protected $wowVersion;

	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function getOnlineCount() {
		return $this->onlineCount;
	}

	/**
	 * @return int
	 */
	public function getRate() {
		return $this->rate;
	}

	/**
	 * @return string
	 */
	public function getWowVersion() {
		return $this->wowVersion;
	}

	/**
	 * @param int $id
	 * @return \Realm
	 */
	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	/**
	 * @param string $name
	 * @return \Realm
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * @param int $onlineCount
	 * @return \Realm
	 */
	public function setOnlineCount($onlineCount) {
		$this->onlineCount = $onlineCount;
		return $this;
	}

	/**
	 * @param string $rate
	 * @return \Realm
	 */
	public function setRate($rate) {
		$this->rate = $rate;
		return $this;
	}

	/**
	 * @param string $wowVersion
	 * @return \Realm
	 */
	public function setWowVersion($wowVersion) {
		$this->wowVersion = $wowVersion;
		return $this;
	}
}