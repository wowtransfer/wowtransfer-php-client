GRANT SELECT, INSERT, UPDATE, DELETE ON `characters`.`chd_transfer` TO '%username%'@'%host%';

GRANT EXECUTE ON PROCEDURE `characters`.`chd_char_del` TO '%username%'@'%host%';
GRANT EXECUTE ON PROCEDURE `characters`.`chd_char_del_debug` TO '%username%'@'%host%';

GRANT SELECT, INSERT ON `characters`.`character_account_data` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `characters`.`character_achievement` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `characters`.`character_achievement_progress` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `characters`.`character_action` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `characters`.`character_equipmentsets` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `characters`.`character_glyphs` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `characters`.`character_homebind` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `characters`.`character_inventory` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `characters`.`character_queststatus` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `characters`.`character_queststatus_rewarded` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `characters`.`character_reputation` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `characters`.`character_skills` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `characters`.`character_spell` TO '%username%'@'%host%';
GRANT SELECT, INSERT ON `characters`.`character_talent` TO '%username%'@'%host%';

-- fields: equipmentCache, playerBytes2, taximask, equipmentCache
GRANT SELECT, INSERT, UPDATE ON `characters`.`characters` TO '%username%'@'%host%';

-- SELECT ifnull(MAX(`guid`), 0) + 1 INTO @item_guid FROM `item_instance`
GRANT SELECT, INSERT ON `characters`.`item_instance` TO '%username%'@'%host%';

-- GRANT SHOW VIEW ON auth.account TO %username%@%host%;
GRANT SELECT (`id`, `username`, `sha_pass_hash`, `online`) ON `auth`.`account` TO '%username%'@'%host%';
GRANT SELECT ON `auth`.`account_access` TO '%username%'@'%host%';