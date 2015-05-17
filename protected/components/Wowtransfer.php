<?php

/**
 * Main class of wowtransfer.com service
 */
class Wowtransfer
{
	const TCONFIG_TYPE_PRIVATE = 0;
	const TCONFIG_TYPE_PUBLIC  = 1;

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
			'achievement' => array(),
			'action'      => array(),
			'bind'        => array(),
			'bag'         => array(),
			'bank'        => array(),
			'criterias'   => array(),
			'critter'     => array(),
			'currency'    => array(),
			'equipment'   => array('disabled' => 1),
			'glyph'       => array(),
			'inventory'   => array(),
			'mount'       => array(),
			'pmacro'      => array('disabled' => 1),
			'quest'       => array(),
			'questlog'    => array(),
			'reputation'  => array(),
			'skill'       => array(),
			'skillspell'  => array(),
			'spell'       => array(),
			'statistic'   => array(),
			'talent'      => array(),
			'taxi'        => array(),
			'title'       => array(),
		];
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
	 * @return string Addon's version
	 */
	public function getAddonVersion() {
		return '1.11';
	}

	/**
	 * @return string PHP client version
	 */
	public function getChdphpVersion() {
		return '1.0';
	}

	/**
	 * @return array|false
	 * @throws Exception
	 */
	public function getCores() {
		$defaultValue = [];
		$ch = $this->_ch;
		curl_setopt($ch, CURLOPT_URL, $this->getApiUrl('/cores'));
		$this->lastHttpResponse = curl_exec($ch);
		$this->lastHttpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$cores = json_decode($this->lastHttpResponse, true);
		if (!$cores) {
			$this->lastError = "Could't get cores from service";
			return $defaultValue;
		}
		if ($this->lastHttpStatus !== 200) {
			$this->lastError = isset($cores['error_message']) ? $cores['error_message'] : 'Error ' . $this->lastHttpStatus;
			return $defaultValue;
		}

		return $cores;
	}

	/**
	 * @return array
	 */
	public function getTransferConfigs() {
		$defaultValue = [];
		$ch = $this->_ch;
		$url = $this->getApiUrl('/tconfigs' . '?access_token=' . $this->getAccessToken());
		curl_setopt($ch, CURLOPT_URL, $url);
		$this->lastHttpResponse = curl_exec($ch);
		$this->lastHttpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$tconfigs = json_decode($this->lastHttpResponse, true);
		if (!$tconfigs) {
			$this->lastError = "Couldn't get transfer configurations from service";
			return $defaultValue;
		}
		if ($this->lastHttpStatus !== 200) {
			$this->lastError = isset($tconfigs['error_message']) ? $tconfigs['error_message'] : 'Error ' . $this->lastHttpStatus;
			return $defaultValue;
		}

		return $tconfigs;
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
	 *
	 * @return string Sql script (200) or error message (501)
	 */
	public function dumpToSql($dumpLua, $accountId, $configuration) {
		$defaultValue = '';
		$filePath = sys_get_temp_dir() . '/' . uniqid() . '.lua';
		$file = fopen($filePath, 'w'); // TODO: replace to object
		if (!$file) {
			$this->lastError = 'fopen() failed! file: ' . $filePath;
			return $defaultValue;
		}
		fwrite($file, $dumpLua);
		fclose($file);
		$ch = $this->_ch;
		curl_setopt($ch, CURLOPT_URL, $this->getApiUrl('/dumps/sql'));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: multipart/form-data'));
		curl_setopt($ch, CURLOPT_POST, 1);
		$postfields = array(
			'dump_lua'         => '@' . $filePath,
			'configuration_id' => $configuration,
			'account_id'       => $accountId,
			'access_token'     => $this->getAccessToken(),
		);
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
			return $defaultValue;
		}

		return $this->lastHttpResponse;
	}

	/**
	 * @return array
	 */
	public function getWowServers() {
		$defaultValue = [];
		$ch = $this->_ch;
		curl_setopt($ch, CURLOPT_URL, $this->getApiUrl('/wowservers'));
		$this->lastHttpResponse = curl_exec($ch);
		$this->lastHttpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$result = json_decode($this->lastHttpResponse, true);
		if (!$this->lastHttpResponse) {
			$this->lastError = "Couldn't get wowservers from service";
			return $defaultValue;
		}
		if ($this->lastHttpStatus !== 200) {
			$this->lastError = isset($result['error_message']) ? $result['error_message'] : 'Error ' . $this->lastHttpStatus;
			return $defaultValue;
		}

		return $result;
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
}