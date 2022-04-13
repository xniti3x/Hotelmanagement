# Module rooms
CREATE TABLE IF NOT EXISTS `ip_rooms` ( 
  `id`        INT(11) NOT NULL AUTO_INCREMENT , 
  `name`      VARCHAR(25) NOT NULL ,
  `kategorie`      VARCHAR(255) NOT NULL ,
  `beschreibung`      VARCHAR(255) NOT NULL ,
  `preis1`      INT(11) NOT NULL ,
  `preis2`      INT(11) ,
  `preis3`      INT(11) ,
  `show_on_system`    TINYINT(1) NOT NULL , 
  `active`    TINYINT(1) NOT NULL , 
  PRIMARY KEY (`id`)
) 
ENGINE = InnoDB
DEFAULT CHARSET = utf8;

INSERT INTO ip_rooms (name,kategorie,beschreibung,preis1,preis2,preis3,show_on_system) VALUES ("Room 1","Einzelzimmer","gutes zimmer...",50,0,0);
INSERT INTO ip_rooms (name,kategorie,beschreibung,preis1,preis2,preis3,show_on_system) VALUES ("Room 2","Einzelzimmer","gutes zimmer...",50,0,0);
INSERT INTO ip_rooms (name,kategorie,beschreibung,preis1,preis2,preis3,show_on_system) VALUES ("Room 3","Einzelzimmer","gutes zimmer...",50,0,0);
INSERT INTO ip_rooms (name,kategorie,beschreibung,preis1,preis2,preis3,show_on_system) VALUES ("Room 4","Einzelzimmer","gutes zimmer...",50,0,0);
INSERT INTO ip_rooms (name,kategorie,beschreibung,preis1,preis2,preis3,show_on_system) VALUES ("Room 5","Doppelzimmer","gutes zimmer...",60,80,0);
INSERT INTO ip_rooms (name,kategorie,beschreibung,preis1,preis2,preis3,show_on_system) VALUES ("Room 6","Doppelzimmer","gutes zimmer...",60,80,0);
INSERT INTO ip_rooms (name,kategorie,beschreibung,preis1,preis2,preis3,show_on_system) VALUES ("Room 7","Dreibettzimmer","gutes zimmer...",65,85,100);

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