# Module "rooms"
CREATE TABLE IF NOT EXISTS `ip_rooms` (
  `id`        INT(11) NOT NULL AUTO_INCREMENT,
  `name`      VARCHAR(50)      DEFAULT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;

INSERT INTO ip_rooms (name) VALUES ("Room 1");
INSERT INTO ip_rooms (name) VALUES ("Room 2");
INSERT INTO ip_rooms (name) VALUES ("Room 3");
INSERT INTO ip_rooms (name) VALUES ("Room 4");
INSERT INTO ip_rooms (name) VALUES ("Room 5");
INSERT INTO ip_rooms (name) VALUES ("Room 6");
INSERT INTO ip_rooms (name) VALUES ("Room 7");

# Table ip_invoice_items
ALTER TABLE `ip_invoice_items` ADD `item_date_start` DATE NULL;
ALTER TABLE `ip_invoice_items` ADD `item_date_end` DATE NULL;
ALTER TABLE `ip_invoice_items` ADD `item_room` TINYINT NULL DEFAULT NULL

# set enable permissive search clients to true
UPDATE `ip_settings` SET `setting_value` = '1' WHERE ip_settings.setting_key ='enable_permissive_search_clients';
