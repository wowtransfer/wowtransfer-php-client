<?php

/**
 * Main class of wowtransfer.com service
 */
class Wowtransfer
{
	/**
	 * Curl handle
	 *
	 * @var resource
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

	public function __construct()
	{
		$this->_ch = curl_init();
	}

	public function __destruct()
	{
		curl_close($this->_ch);
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
		if (empty($accessToken)) {
			throw new Exception('Empty access token');
		}

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
	 * @return array Transfer's options
	 * @todo Make loading from wowtransfer.com
	 *       Make locale
	 */
	public static function getTransferOptions() {
		return include(ToptionsConfigForm::getConfigFilePath());
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
	 */
	public function getCores() {
		$ch = $this->_ch;
		curl_setopt($ch, CURLOPT_URL, $this->getBaseUrl() . '/cores');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$result = json_decode($result, true);
		if (!$result) {
			throw new \Exception("Could't get cores from service");
		}
		if ($status !== 200) {
			throw new \Exception($result['error_message']);
		}

		return $result;
	}

	/**
	 * @return array
	 */
	public function getTransferConfigs() {
		$ch = $this->_ch;
		curl_setopt($ch, CURLOPT_URL, $this->getBaseUrl() . '/tconfigs' . '?access_token=' . $this->getAccessToken());
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$tconfigs = array();

		$tconfigsSource = json_decode($result, true);
		if (!$tconfigsSource) {
			return $tconfigs;
		}
		if ($status !== 200) {
			return $tconfigs;
		}

		foreach ($tconfigsSource as $config) {
			$tconfigs[] = array(
				'id'    => $config['id'],
				'name'  => $config['name'],
				'title' => $config['title'],
				'udate' => $config['udate'],
				'type'  => $config['type'],
			);
		}

		return $tconfigs;
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
		$filePath = sys_get_temp_dir() . '/' . uniqid() . '.lua';
		$file = fopen($filePath, 'w'); // TODO: replace to object
		if (!$file) {
			throw new Exception('fopen() failed! file: ' . $filePath);
		}
		fwrite($file, $dumpLua);
		fclose($file);

		$ch = $this->_ch;
		curl_setopt($ch, CURLOPT_URL, $this->getBaseUrl() . '/dumps/sql');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: multipart/form-data'));
		curl_setopt($ch, CURLOPT_POST, 1);
		$postfields = array(
			'dump_lua'         => '@' . $filePath,
			'configuration_id' => $configuration,
			'account_id'       => $accountId,
			'access_token'     => $this->getAccessToken(),
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);

		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		unlink($filePath);

		if ($status != 200) {
			$response = json_decode($result, true);
			if ($response) {
				$error = isset($response['error_message']) ? $response['error_message'] : 'Error';
			}
			else {
				$error = 'Erorr (' . $status . ')';
			}

			throw new CHttpException(501, 'Service: ' . $error);
		}

		return $result;
	}

	/**
	 * @return array
	 */
	public function getWowServers() {
		$ch = $this->_ch;
		curl_setopt($ch, CURLOPT_URL, $this->serviceBaseUrl . 'wowservers');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		$servers = json_decode($result, true);

		return $servers;
	}
}