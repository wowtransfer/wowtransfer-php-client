<?php

/**
 *
 */
class CreateCharForm
{
	private $_transfer; // ChdTransfer model

	/**
	 *
	 */
	public function __construct($transfer)
	{
		$this->_transfer = $transfer;
	}

	/**
	 *
	 */
	public function GetSql()
	{
		
	}

	/**
	 *
	 */
	public function RunSql()
	{
		
	}

	/**
	 * 
	 */
	public function createChar()
	{
		$result = array();
		$result['retrieve_sql_error'] = '';
		$result['run_sql_error'] = '';
		// item:
		// ['query'] = string, body
		// ['status'] = integer, 1 - success, 0 - fail
		// ['error'] = string, error
		$result['queries'] = array();
		$result['sql'] = '';

		if ($this->_transfer->char_guid > 0)
		{
			$result['retrieve_sql_error'] = "Character exists! GUID = " . $_transfer->char_guid . '.';
			return $result;
		}

		$dumpLua = $this->_transfer->luaDumpFromDb();

		$service = new Wowtransfer;
		$result['sql'] = $service->dumpToSql($dumpLua, $this->_transfer->account_id, 'global_335a');

		return $result;
	}
}