-- on `transfer` table
GRANT SELECT, INSERT, UPDATE, DELETE ON `%db_characters%`.`%transfer_table%` TO '%username%'@'%host%';

-- on `characters` database
GRANT SELECT, INSERT ON `%db_characters%`.`character_action` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `%db_characters%`.`character_account_data` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `%db_characters%`.`character_achievement` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `%db_characters%`.`character_achievement_progress` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `%db_characters%`.`character_equipmentsets` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `%db_characters%`.`character_glyphs` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `%db_characters%`.`character_homebind` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `%db_characters%`.`character_inventory` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `%db_characters%`.`character_queststatus` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `%db_characters%`.`character_reputation` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `%db_characters%`.`character_skills` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `%db_characters%`.`character_spell` TO '%username%'@'%host%';

-- update fields... equipmentCache, playerBytes2, taximask, equipmentCache
GRANT SELECT, INSERT, UPDATE ON `%db_characters%`.`characters` TO '%username%'@'%host%';

-- SELECT ifnull(MAX(`guid`), 0) + 1 INTO @item_guid FROM `item_instance`
GRANT SELECT, INSERT ON `%db_characters%`.`item_instance` TO '%username%'@'%host%';

-- realmd database
GRANT SELECT ON `%db_auth%`.`account` TO '%username%'@'%host%';
