<?php

/**
 * Main class of wowtransfer.com service
 */
class Wowtransfer
{
	private $serviceBaseUrl = 'http://wowtransfer/api.php/api/v1/';

	/**
	 * @return array Transfer's options
	 * @todo Make loading from wowtransfer.com
	 *       Make locale
	 */
	public static function getTransferOptions()
	{
		return include(ToptionsConfigForm::getConfigFilePath());
	}

	/**
	 * @return string Actual version of API
	 */
	public function getApiVersion()
	{
		return '1.0';
	}

	/**
	 * @return string Addon's version
	 */
	public function getAddonVersion()
	{
		return '1.11';
	}

	/**
	 * @return string PHP client version
	 */
	public function getChdphpVersion()
	{
		return '1.0';
	}

	public function getCores()
	{
		$ch = curl_init($this->serviceBaseUrl);
		curl_setopt($ch, CURLOPT_URL, $this->serviceBaseUrl . 'cores');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$cores = json_decode($result, true);

		return $cores;
	}

	public function getTransferConfigs()
	{
		/*$ch = curl_init($this->serviceBaseUrl);
		curl_setopt($ch, CURLOPT_URL, $this->serviceBaseUrl . 'tconfigs');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		$cores = json_decode($result, true);*/

		$cores = array(
			array('name' => 'config1', 'title' => 'title1'),
			array('name' => 'config2', 'title' => 'title2'),
		);

		return $cores;
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
	public function dumpToSql($dumpLua, $accountId, $configuration)
	{
		$filePath = sys_get_temp_dir() . '/' . uniqid() . '.lua';
		$file = fopen($filePath, 'w');
		if (!$file)
			return 'fopen failed... todo!';
		fwrite($file, $dumpLua);
		fclose($file);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->serviceBaseUrl . 'dumps/sql');
		//curl_setopt($ch, CURLOPT_HEADER, 1);
		//curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: multipart/form-data'));
		curl_setopt($ch, CURLOPT_POST, 1);
		$postfields = array(
			'dump_lua' => '@' . $filePath,
			'transferConf' => $configuration,
			'account_id' => $accountId
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
		//curl_setopt($ch, CURLOPT_VERBOSE, true);
		//$verbose = fopen('c:/1.txt', 'w');
		//curl_setopt($ch, CURLOPT_STDERR, $verbose);

		$result = curl_exec($ch);
		$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);

		return print_r($result, true);

		unlink($filePath);

		if ($status != 200)
		{
			throw new CHttpException(501, print_r($result, true));
		}

		return $result;
	}
}