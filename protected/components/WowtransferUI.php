<?php

class WowtransferUI extends Wowtransfer
{
	private static $_cores = null;
	private static $_tconfigs = null;

	/**
	 * @return array Associative array kind of 'id' => 'name'
	 */
	public function getTransferConfigs()
	{
		$transferConfigs = array();

		if (self::$_tconfigs === null)
			self::$_tconfigs = parent::getTransferConfigs();

		if (is_array(self::$_tconfigs))
		{
			foreach (self::$_tconfigs as $config)
				$transferConfigs[$config['id']] = $config['name'];
		}

		return $transferConfigs;
	}

	/**
	 * @return array Associative array kind of 'name' => 'title'
	 */
	public function getCores()
	{
		$cores = array();

		if (self::$_cores === null) {
			self::$_cores = parent::getCores();
		}

		if (is_array(self::$_cores))
		{
			foreach (self::$_cores as $core)
				$cores[$core['name']] = $core['title'];
		}

		return $cores;
	}

	/**
	 * @return array
	 *
	 * incluing empty item [''] = ''
	 */
	public function getWowServers()
	{
		$serversSource = parent::getWowServers();

		$servers = array('' => '');
		if (is_array($serversSource))
		{
			for ($i = 0; $i < count($serversSource); ++$i)
			{
				$server = $serversSource[$i];
				$servers[$server['site_url']] = $server['title'];
			}
		}
		asort($servers);

		return $servers;
	}
}