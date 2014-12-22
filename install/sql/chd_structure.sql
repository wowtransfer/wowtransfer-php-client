DROP TABLE IF EXISTS `chd_transfer`;

CREATE TABLE `chd_transfer` (
`id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Transfer Identifier',
`account_id` int unsigned NOT NULL DEFAULT 0 COMMENT 'Account Identifier',
`server` VARCHAR(100) NOT NULL DEFAULT '',
`realmlist` VARCHAR(40) NOT NULL DEFAULT '',
`realm` VARCHAR(40) NOT NULL DEFAULT '',
`username_old` VARCHAR(12) NOT NULL DEFAULT '' COMMENT 'Name on remote server',
`username_new` VARCHAR(12) NOT NULL DEFAULT '' COMMENT 'Name on current server',
`char_guid` INT unsigned NOT NULL DEFAULT 0 COMMENT 'Character GUID',
`create_char_date` timestamp NULL DEFAULT NULL COMMENT 'Character creating date',
`create_transfer_date` timestamp DEFAULT CURRENT_TIMESTAMP COMMENT 'Transfer creating date',
`status` enum ('process', 'check', 'cancel', 'apply', 'game','cart') NOT NULL DEFAULT 'process',
`account` VARCHAR(32) NOT NULL DEFAULT '' COMMENT 'User acoount name',
`pass` VARCHAR(40) NOT NULL DEFAULT '' COMMENT 'User password',
`file_lua_crypt` TINYINT DEFAULT 0 COMMENT 'Crypted/Uncrypted lua file',
`file_lua` MEDIUMBLOB NOT NULL COMMENT 'dump *.lua file',
`options` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Transfer options',
`comment` VARCHAR(255) NOT NULL DEFAULT '',

PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;