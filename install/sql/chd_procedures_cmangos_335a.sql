DELIMITER $$

DROP PROCEDURE IF EXISTS `chd_char_del`$$

CREATE PROCEDURE `chd_char_del`(IN p_char_guid INT)
	SQL SECURITY INVOKER
BEGIN
	DECLARE nGUID INT UNSIGNED;

	SET @CHD_RES = 0;
	SELECT ct.char_guid INTO nGUID FROM chd_transfer ct WHERE (ct.char_guid=p_char_guid) AND
		EXISTS(SELECT * FROM characters ch WHERE ch.guid=ct.char_guid);
	IF (nGUID) THEN
		DELETE FROM characters WHERE guid = nGUID;
		DELETE FROM character_account_data WHERE guid = nGUID;
		DELETE FROM character_declinedname WHERE guid = nGUID;
		DELETE FROM character_action WHERE guid = nGUID;
		DELETE FROM character_aura WHERE guid = nGUID;
		DELETE FROM character_battleground_data WHERE guid = nGUID;
		DELETE FROM character_gifts WHERE guid = nGUID;
		DELETE FROM character_glyphs WHERE guid = nGUID;
		DELETE FROM character_homebind WHERE guid = nGUID;
		DELETE FROM character_instance WHERE guid = nGUID;
		DELETE FROM groups WHERE leaderGuid = nGUID;
		DELETE FROM character_inventory WHERE guid = nGUID;
		DELETE FROM character_queststatus WHERE guid = nGUID;
		DELETE FROM character_queststatus_daily WHERE guid = nGUID;
		DELETE FROM character_queststatus_weekly WHERE guid = nGUID;
		DELETE FROM character_reputation WHERE guid = nGUID;
		DELETE FROM character_skills WHERE guid = nGUID;
		DELETE FROM character_spell WHERE guid = nGUID;
		DELETE FROM character_spell_cooldown WHERE guid = nGUID;
		DELETE FROM character_talent WHERE guid = nGUID;
		DELETE FROM item_instance WHERE owner_guid = nGUID;
		DELETE FROM character_social WHERE guid = nGUID OR friend = nGUID;
		DELETE FROM mail WHERE receiver = nGUID;
		DELETE FROM mail_items WHERE receiver = nGUID;
		DELETE FROM character_pet WHERE owner = nGUID;
		DELETE FROM character_pet_declinedname WHERE owner = nGUID;
		DELETE FROM character_achievement WHERE guid = nGUID;
		DELETE FROM character_achievement_progress WHERE guid = nGUID;
		DELETE FROM character_equipmentsets WHERE guid = nGUID;
		DELETE FROM guild_eventlog WHERE PlayerGuid1 = nGUID OR PlayerGuid2 = nGUID;
		DELETE FROM guild_bank_eventlog WHERE PlayerGuid = nGUID;

		UPDATE chd_transfer ct SET ct.char_guid = 0 WHERE ct.char_guid = nGUID;
		SET @CHD_RES = 1;
	END IF;
END$$

DROP PROCEDURE IF EXISTS `chd_char_del_debug`$$

CREATE PROCEDURE `chd_char_del_debug`(IN p_char_guid INT)
	SQL SECURITY INVOKER
BEGIN
	SET @CHD_RES = 0;

	DELETE FROM characters WHERE guid = p_char_guid;
	DELETE FROM character_account_data WHERE guid = p_char_guid;
	DELETE FROM character_declinedname WHERE guid = p_char_guid;
	DELETE FROM character_action WHERE guid = p_char_guid;
	DELETE FROM character_aura WHERE guid = p_char_guid;
	DELETE FROM character_battleground_data WHERE guid = p_char_guid;
	DELETE FROM character_gifts WHERE guid = p_char_guid;
	DELETE FROM character_glyphs WHERE guid = p_char_guid;
	DELETE FROM character_homebind WHERE guid = p_char_guid;
	DELETE FROM character_instance WHERE guid = p_char_guid;
	DELETE FROM groups WHERE leaderGuid = p_char_guid;
	DELETE FROM character_inventory WHERE guid = p_char_guid;
	DELETE FROM character_queststatus WHERE guid = p_char_guid;
	DELETE FROM character_queststatus_daily WHERE guid = p_char_guid;
	DELETE FROM character_queststatus_weekly WHERE guid = p_char_guid;
	DELETE FROM character_reputation WHERE guid = p_char_guid;
	DELETE FROM character_skills WHERE guid = p_char_guid;
	DELETE FROM character_spell WHERE guid = p_char_guid;
	DELETE FROM character_spell_cooldown WHERE guid = p_char_guid;
	DELETE FROM character_talent WHERE guid = p_char_guid;
	DELETE FROM item_instance WHERE owner_guid = p_char_guid;
	DELETE FROM character_social WHERE guid = p_char_guid OR friend = p_char_guid;
	DELETE FROM mail WHERE receiver = p_char_guid;
	DELETE FROM mail_items WHERE receiver = p_char_guid;
	DELETE FROM character_pet WHERE owner = p_char_guid;
	DELETE FROM character_pet_declinedname WHERE owner = p_char_guid;
	DELETE FROM character_achievement WHERE guid = p_char_guid;
	DELETE FROM character_achievement_progress WHERE guid = p_char_guid;
	DELETE FROM character_equipmentsets WHERE guid = p_char_guid;
	DELETE FROM guild_eventlog WHERE PlayerGuid1 = p_char_guid OR PlayerGuid2 = p_char_guid;
	DELETE FROM guild_bank_eventlog WHERE PlayerGuid = p_char_guid;
	
	UPDATE transfer ct SET ct.char_guid = 0 WHERE ct.char_guid = p_char_guid;

	SET @CHD_RES = 1;
END$$