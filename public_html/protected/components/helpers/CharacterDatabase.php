<?php

/**
 * Character db wrapper
 * TODO: the base class, add other cores
 */
class CharacterDatabase
{
	/**
	 * @var CDbConnection
	 */
	protected $db;

	/**
	 * @param CDbConnection $db
	 */
	public function __construct($db) {
		$this->db = $db;
	}

	public function deleteCharacter($transferId) {
		$transferTable = Config::getInstance()->getTransferTable();
		if (empty($transferTable)) {
			throw new \CharacterDeletionException(Yii::t('app', 'Empty transfer table name'));
		}
		if ($transferId <= 0) {
			throw new \CharacterDeletionException(Yii::t('app', 'Invalid transfer {n}', [$transferId]));
		}

		$db = $this->db;

		// TODO: params the character table
		$getCharacterCommand = $db->createCommand();
		$guid = $getCharacterCommand
			->select('ct.char_guid')
			->from($transferTable . ' ct')
			->join('characters c', 'c.guid = ct.char_guid')
			->where('ct.id = :transfer_id', ['transfer_id' => $transferId])
			->queryScalar();
		if (empty($guid)) {
			$message = Yii::t('app', 'The character created by transfer ID = {id} not found',
				['{id}' => $transferId]);
			throw new \CharacterDeletionException($message);
		}

		// But on the test server this is absent
		// is guild leader
		// ...
		// is arena team captain
		// ...

		$transaction = $db->beginTransaction();
		try {

			$db->createCommand()->update($transferTable,
				['char_guid' => 0, 'create_char_date' => null],
				'id = ' . $transferId
			);

			$deleteQueries = $this->getCommonDeletionQueries($guid);
			foreach ($deleteQueries as $deleteQuery) {
				$db->createCommand($deleteQuery)->execute();
			}

			$transaction->commit();
		} catch (Exception $ex) {
			$transaction->rollback();
			throw new \CharacterDeletionException($ex->getMessage());
		}

		/*
		CHAR_SEL_CHAR_COD_ITEM_MAIL
		 SELECT id, messageType, mailTemplateId, sender, subject, body, money, has_items
		 FROM mail
		 WHERE receiver = ? AND has_items <> 0 AND cod <> 0

		 DELETE FROM mail WHERE id = ?
		 DELETE FROM mail_items WHERE mail_id = ?

		SELECT creatorGuid, giftCreatorGuid, count, duration, charges, flags, enchantments, randomPropertyId, durability, playedTime, text, item_guid, itemEntry, owner_guid FROM mail_items mi JOIN item_instance ii ON mi.item_guid = ii.guid WHERE mail_id = ?
		DELETE FROM item_instance WHERE guid = ?

		SELECT id FROM character_pet WHERE owner = ?
		// ...
		*/

		//...

		/* TODO:
		SELECT account, COUNT(guid) FROM characters WHERE account = ? GROUP BY account
		UPDATE ...
		DELETE FROM realmcharacters WHERE acctid = ? AND realmid = ?
		*/

		return true;
	}

	/**
	 * @return string[]
	 */
	protected function getCommonDeletionQueries($guid) {
		return [
			"DELETE FROM characters WHERE guid = $guid",
			"DELETE FROM character_account_data WHERE guid = $guid",
			"DELETE FROM character_declinedname WHERE guid = $guid",
			"DELETE FROM character_action WHERE guid = $guid",
			"DELETE FROM character_arena_stats WHERE guid = $guid",
			"DELETE FROM character_aura WHERE guid = $guid",
			"DELETE FROM character_battleground_data WHERE guid = $guid",
			"DELETE FROM character_battleground_random WHERE guid = $guid",
			"DELETE FROM character_gifts WHERE guid = $guid",
			"DELETE FROM character_homebind WHERE guid = $guid",
			"DELETE FROM character_instance WHERE guid = $guid",
			"DELETE FROM character_inventory WHERE guid = $guid",
			"DELETE FROM character_queststatus WHERE guid = $guid",
			"DELETE FROM character_queststatus_rewarded WHERE guid = $guid",
			"DELETE FROM character_reputation WHERE guid = $guid",
			"DELETE FROM character_spell WHERE guid = $guid",
			"DELETE FROM character_spell_cooldown WHERE guid = $guid",
			"DELETE FROM gm_ticket WHERE playerGuid = $guid",
			"DELETE FROM item_instance WHERE owner_guid = $guid",
			"DELETE FROM character_social WHERE guid = $guid OR friend = $guid",
			"DELETE FROM mail WHERE receiver = $guid",
			"DELETE FROM mail_items WHERE receiver = $guid",
			"DELETE FROM character_pet WHERE owner = $guid",
			"DELETE FROM character_pet_declinedname WHERE owner = $guid",
			"DELETE FROM character_achievement
				WHERE guid = $guid
				AND achievement NOT BETWEEN '456' AND '467'
				AND achievement NOT BETWEEN '1400' AND '1427'
				AND achievement NOT IN(1463, 3117, 3259)",
			"DELETE FROM character_achievement_progress WHERE guid = $guid",
			"DELETE FROM character_equipmentsets WHERE guid = $guid",
			"DELETE FROM guild_eventlog WHERE PlayerGuid1 = $guid OR PlayerGuid2 = $guid",
			"DELETE FROM guild_bank_eventlog WHERE PlayerGuid = $guid",
			"DELETE FROM character_glyphs WHERE guid = $guid",
			"DELETE FROM character_queststatus_daily WHERE guid = $guid",
			"DELETE FROM character_queststatus_weekly WHERE guid = $guid",
			"DELETE FROM character_queststatus_monthly WHERE guid = $guid",
			"DELETE FROM character_queststatus_seasonal WHERE guid = $guid",
			"DELETE FROM character_talent WHERE guid = $guid",
			"DELETE FROM character_skills WHERE guid = $guid",
			"DELETE FROM character_stats WHERE guid = $guid",
			"DELETE FROM corpse WHERE guid = $guid",
			// "DELETE FROM groups WHERE leaderGuid = $guid",
		];
	}

	public function deleteCharacterByGuid($guid) {

	}
}

class CharacterDeletionException extends \Exception {}
