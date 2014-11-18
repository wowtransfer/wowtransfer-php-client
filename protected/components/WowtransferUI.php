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

		if (self::$_cores === null)
			self::$_cores = parent::getCores();

		if (is_array(self::$_cores))
		{
			foreach (self::$_cores as $core)
				$cores[$core['name']] = $core['title'];
		}

		return $cores;
	}
}