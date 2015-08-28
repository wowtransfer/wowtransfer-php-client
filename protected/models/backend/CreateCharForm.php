<?php

/**
 *
 */
class CreateCharForm
{
	/**
	 * @var ChdTransfer
	 */
	private $_transfer;

	public function __construct($transfer) {
		$this->_transfer = $transfer;
	}

	/**
	 * @return array
	 */
	public static function getDefaultResult() {
		return array(
			'errors'   => array(),
			'warnings' => array(),
			'sql'      => '',
			'queries'  => array(),
		);
	}

	/**
	 * Runs the SQL script
	 *
	 * @param string $sql
	 * @param integer $accountGuid
	 *
	 * @return array
	 *    index => array(
	 *      ['query'] => string,
	 *      ['status'] => count of updated rows,
	 *    ),
	 *    ['errors'] => array of string,
	 */
	private function runSql($sql, $accountGuid) {
		$result = array();

		if (empty($sql)) {
			$result['error'] = 'Empty SQL script';
			return $result;
		}

		$queries = explode(';', $sql);
		$db = Yii::app()->db;

		$transaction = $db->beginTransaction();

		try {
			$query1 = [
				'query' => '',
				'status' => 0
			];

			$command = $db->createCommand();

			$query1['query'] = 'SET @ACC_GUID = ' . $accountGuid;
			$command->text = $query1['query'];
			$query1['status'] = $command->execute();
			$result[] = $query1;

			foreach ($queries as $query) {
				$query = trim($query);
				if (empty($query)) {
					continue;
				}

				$query1['query'] = substr($query, 0, 255);
				$command->text = $query;
				$query1['status'] = $command->execute();
				$result[] = $query1;
			}

			$transaction->commit();
		}
		catch (\Exception $ex) {
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
		if ($result) {
			$guid = intval($result);
		}

		return $guid;
	}

	/**
	 * @param string $configName
	 *
	 * @return array ['sql'] => 'SQL script'
	 *               ['queries'] => array (
	 *                 'query' => string,
	 *                 'status' => integer,
	 *               ),
	 *               ['error'] => string
	 *               ['guid'] => GUID of character
	 */
	public function createChar($configName) {
		$result = self::getDefaultResult();

		if ($this->_transfer->char_guid > 0) {
			$result['errors'][] = Yii::t('app', 'Character exists! GUID = {n}', [$this->_transfer->char_guid]);
			return $result;
		}

		$dumpLua = $this->_transfer->luaDumpFromDb();
		$toptions = $this->_transfer->getTransferOptionsFromDb();
		$service = new Wowtransfer();
		$service->setAccessToken(Yii::app()->params['accessToken']);
		$service->setBaseUrl(Yii::app()->params['apiBaseUrl']);

		try {
			// TODO: service will be return a queries
			$result['sql'] = $service->dumpToSql($dumpLua, $this->_transfer->account_id, $configName, $toptions);
			if ($service->getLastError()) {
				$result['errors'][] = 'От сервиса: ' . $service->getLastError();
			}
		}
		catch (exception $e) {
			$result['errors'][] = $e->getMessage();
			return $result;
		}

		$queries = $this->runSql($result['sql'], $this->_transfer->account_id);
		if (isset($queries['error'])) {
			$result['errors'][] = $queries['error'];
			unset($queries['error']);
		}
		else {
			$guid = $this->getCharacterGuid();
			$result['guid'] = $guid;
			$this->_transfer->char_guid = $guid;
			$this->_transfer->create_char_date = date('Y-m-d h:i:s');
			if (!$this->_transfer->save(false, array('char_guid', 'create_char_date'))) {
				$result['errors'][] = Yii::t('app', 'Saving failed');
			}
		}
		$result['queries'] = $queries;

		return $result;
	}
}