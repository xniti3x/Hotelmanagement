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
INSERT INTO ip_rooms (name) VALUES ("Room 8");
INSERT INTO ip_rooms (name) VALUES ("Room 9");

# Table ip_invoice_items
ALTER TABLE `ip_invoice_items` ADD `item_date_start` DATE NULL;
ALTER TABLE `ip_invoice_items` ADD `item_date_end` DATE NULL;
ALTER TABLE `ip_invoice_items` ADD `item_room` TINYINT NULL DEFAULT NULL

# set enable permissive search clients to true
UPDATE `ip_settings` SET `setting_value` = '1' WHERE ip_settings.setting_key ='enable_permissive_search_clients';

# insert default tax_rates
INSERT INTO `ip_tax_rates` (`tax_rate_id`, `tax_rate_name`, `tax_rate_percent`) VALUES (NULL, '7', '7'), (NULL, '19', '19');

# insert default units
INSERT INTO `ip_units` (`unit_id`, `unit_name`, `unit_name_plrl`) VALUES (NULL, 'Nacht', 'Nächte');

# insert product DEFAULT
INSERT INTO `ip_products` (`product_id`, `family_id`, `product_sku`, `product_name`, `product_description`, `product_price`, `purchase_price`, `provider_name`, `tax_rate_id`, `unit_id`, `product_tariff`) VALUES (NULL, NULL, 1, 'Übernachtung ohne Frühstück', '', '50', NULL, NULL, '1', '1', NULL);
INSERT INTO `ip_products` (`product_id`, `family_id`, `product_sku`, `product_name`, `product_description`, `product_price`, `purchase_price`, `provider_name`, `tax_rate_id`, `unit_id`, `product_tariff`) VALUES (NULL, NULL, 1, 'Übernachtung', '', '50', NULL, NULL, '1', '1', NULL);
INSERT INTO `ip_products` (`product_id`, `family_id`, `product_sku`, `product_name`, `product_description`, `product_price`, `purchase_price`, `provider_name`, `tax_rate_id`, `unit_id`, `product_tariff`) VALUES (NULL, NULL, -1, 'Frühstück', '', '10', NULL, NULL, '2', NULL, NULL);

CREATE TABLE `ip_timesheet` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `day` date NOT NULL,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `duration` time NOT NULL,
  `notes` text NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;