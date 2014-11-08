DELIMITER $$

DROP PROCEDURE IF EXISTS `chd_char_del`$$

CREATE PROCEDURE characters.chd_char_del(IN p_transfer_id int, IN p_transfer_table varchar(64))
proc_label:BEGIN
	DECLARE v_char_guid INT UNSIGNED DEFAULT 0;
	DECLARE v_stmt varchar(255);

	SET @CHD_RES = 0;

	IF (p_transfer_table IS NULL) OR (LENGTH(p_transfer_id) = 0) THEN
		LEAVE proc_label;
	END IF;

	SET @query := CONCAT(
		'SELECT chd.char_guid INTO @char_guid ',
		'FROM ', p_transfer_table, ' chd, characters ch ',
		'WHERE chd.id = ', p_transfer_id, ' AND chd.char_guid = ch.guid');
	PREPARE v_stmt FROM @query;
	EXECUTE v_stmt;
	DEALLOCATE PREPARE v_stmt;

	SET v_char_guid = @char_guid;
	IF (v_char_guid) THEN
		DELETE FROM characters WHERE guid = v_char_guid;
		DELETE FROM character_account_data WHERE guid = v_char_guid;
		DELETE FROM character_declinedname WHERE guid = v_char_guid;
		DELETE FROM character_action WHERE guid = v_char_guid;
		DELETE FROM character_aura WHERE guid = v_char_guid;
		DELETE FROM character_battleground_data WHERE guid = v_char_guid;
		DELETE FROM character_gifts WHERE guid = v_char_guid;
		DELETE FROM character_glyphs WHERE guid = v_char_guid;
		DELETE FROM character_homebind WHERE guid = v_char_guid;
		DELETE FROM character_instance WHERE guid = v_char_guid;
		DELETE FROM groups WHERE leaderGuid = v_char_guid;
		DELETE FROM character_inventory WHERE guid = v_char_guid;
		DELETE FROM character_queststatus WHERE guid = v_char_guid;
		DELETE FROM character_queststatus_daily WHERE guid = v_char_guid;
		DELETE FROM character_queststatus_weekly WHERE guid = v_char_guid;
		DELETE FROM character_queststatus_rewarded WHERE guid = v_char_guid;
		DELETE FROM character_reputation WHERE guid = v_char_guid;
		DELETE FROM character_skills WHERE guid = v_char_guid;
		DELETE FROM character_spell WHERE guid = v_char_guid;
		DELETE FROM character_spell_cooldown WHERE guid = v_char_guid;
		DELETE FROM character_talent WHERE guid = v_char_guid;
		DELETE FROM item_instance WHERE owner_guid = v_char_guid;
		DELETE FROM character_social WHERE guid = v_char_guid OR friend = v_char_guid;
		DELETE FROM mail WHERE receiver = v_char_guid;
		DELETE FROM mail_items WHERE receiver = v_char_guid;
		DELETE FROM character_pet WHERE owner = v_char_guid;
		DELETE FROM character_pet_declinedname WHERE owner = v_char_guid;
		DELETE FROM character_achievement WHERE guid = v_char_guid;
		DELETE FROM character_achievement_progress WHERE guid = v_char_guid;
		DELETE FROM character_equipmentsets WHERE guid = v_char_guid;
		DELETE FROM guild_eventlog WHERE PlayerGuid1 = v_char_guid OR PlayerGuid2 = v_char_guid;
		DELETE FROM guild_bank_eventlog WHERE PlayerGuid = v_char_guid;

	SET @query := CONCAT(
		'UPDATE ', p_transfer_table, ' ',
		'SET char_guid = 0, create_char_date = NULL ',
		'WHERE id = ', p_transfer_id);
	PREPARE v_stmt FROM @query;
	EXECUTE v_stmt;
	DEALLOCATE PREPARE v_stmt;

	SET @CHD_RES = 1;
	END IF;
END$$

DROP PROCEDURE IF EXISTS `chd_char_del_debug`$$

CREATE PROCEDURE `chd_char_del_debug`(IN char_guid INT)
BEGIN
	DELETE FROM characters WHERE guid = char_guid;
	DELETE FROM character_account_data WHERE guid = char_guid;
	DELETE FROM character_declinedname WHERE guid = char_guid;
	DELETE FROM character_action WHERE guid = char_guid;
	DELETE FROM character_aura WHERE guid = char_guid;
	DELETE FROM character_battleground_data WHERE guid = char_guid;
	DELETE FROM character_gifts WHERE guid = char_guid;
	DELETE FROM character_glyphs WHERE guid = char_guid;
	DELETE FROM character_homebind WHERE guid = char_guid;
	DELETE FROM character_instance WHERE guid = char_guid;
	DELETE FROM groups WHERE leaderGuid = char_guid;
	DELETE FROM character_inventory WHERE guid = char_guid;
	DELETE FROM character_queststatus WHERE guid = char_guid;
	DELETE FROM character_queststatus_daily WHERE guid = char_guid;
	DELETE FROM character_queststatus_weekly WHERE guid = char_guid;
	DELETE FROM character_queststatus_rewarded WHERE guid = char_guid;
	DELETE FROM character_reputation WHERE guid = char_guid;
	DELETE FROM character_skills WHERE guid = char_guid;
	DELETE FROM character_spell WHERE guid = char_guid;
	DELETE FROM character_spell_cooldown WHERE guid = char_guid;
	DELETE FROM character_talent WHERE guid = char_guid;
	DELETE FROM item_instance WHERE owner_guid = char_guid;
	DELETE FROM character_social WHERE guid = char_guid OR friend = char_guid;
	DELETE FROM mail WHERE receiver = char_guid;
	DELETE FROM mail_items WHERE receiver = char_guid;
	DELETE FROM character_pet WHERE owner = char_guid;
	DELETE FROM character_pet_declinedname WHERE owner = char_guid;
	DELETE FROM character_achievement WHERE guid = char_guid;
	DELETE FROM character_achievement_progress WHERE guid = char_guid;
	DELETE FROM character_equipmentsets WHERE guid = char_guid;
	DELETE FROM guild_eventlog WHERE PlayerGuid1 = char_guid OR PlayerGuid2 = char_guid;
	DELETE FROM guild_bank_eventlog WHERE PlayerGuid = char_guid;

	UPDATE transfer t set char_guid = 0, create_char_date=NULL WHERE t.char_guid = char_guid;

	SET @CHD_RES = 1;
END$$