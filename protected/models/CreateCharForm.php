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
	private function GetSql()
	{
		
	}

	/**
	 * Runs the SQL script
	 *
	 * @return array
	 *    index => array(
	 *      ['query'] => string,
	 *      ['status'] => count of updated rows,
	 *    ),
	 *    ['error'] => string,
	 */
	private function RunSql($sql)
	{
		$result = array();

		if (empty($sql))
		{
			$result['error'] = 'Empty SQL script';
			return $result;
		}

		$queries = explode(';', $sql);
		$db = Yii::app()->db;

		$transaction = $db->beginTransaction();

		try
		{
			$query1 = array(
				'query' => '',
				'status' => 0
			);

			$command = $db->createCommand();
			foreach ($queries as $query)
			{
				$query = trim($query);
				if (empty($query))
					continue;

				$query1['query'] = substr($query, 0, 255);
				$command->text = $query;
				$query1['status'] = $command->execute();
				$result[] = $query1;
			}

			$transaction->commit();
		}
		catch (exception $ex)
		{
			$query1['status'] = 0;
			$result[] = $query1;
			$transaction->rollback();

			$result['error'] = $ex->getMessage();
		}

		return $result;
	}

	/**
	 * @return integer GUID of character, 0 on error
	 */
	private function getCharacterGuid()
	{
		$guid = 0;

		$connection = Yii::app()->db;

		$command = $connection->createCommand('SELECT @CHAR_GUID');
		$result = $command->queryScalar();
		if ($result)
			$guid = intval($result);

		return $guid;
	}

	/**
	 * @return array ['sql'] => 'SQL script'
	 *               ['queries'] => array (
	 *                 'query' => string,
	 *                 'status' => integer,
	 *               ),
	 *               ['error'] => string
	 *               ['guid'] => GUID of character
	 */
	public function createChar($transferConfigName)
	{
		$result = array();
		$result['error'] = '';
		$result['queries'] = array();
		$result['guid'] = 0;
		$result['sql'] = '';

		if ($this->_transfer->char_guid > 0)
		{
			$result['error'] = "Character exists! GUID = " . $_transfer->char_guid . '.';
			return $result;
		}

		$dumpLua = $this->_transfer->luaDumpFromDb();

		$service = new Wowtransfer;
		try
		{
			$result['sql'] = $service->dumpToSql($dumpLua, $this->_transfer->account_id, $transferConfigName);
		}
		catch (exception $ex)
		{
			$result['error'] = $ex->getMessage();
			return $result;
		}

		$guid = 0;
		$queries = $this->RunSql($result['sql']);
		if (isset($queries['error']))
		{
			$result['error'] = $queries['error'];
			unset($queries['error']);
		}
		else
		{
			$guid = $this->getCharacterGuid();
			$result['guid'] = $guid;
		}

		$result['queries'] = $queries;

		$this->_transfer->char_guid = $guid;
		$this->_transfer->create_char_date = date('Y-m-d h:i:s');
		$this->_transfer->save(false, array('char_guid', 'create_char_date'));

		return $result;
	}
}