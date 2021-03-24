# Module "reservations"
CREATE TABLE IF NOT EXISTS `ip_reservations` (
  `id`        INT(11) NOT NULL AUTO_INCREMENT,
  `title`      VARCHAR(50)      DEFAULT NULL,
  `description`      VARCHAR(50)      DEFAULT NULL,
  `room_id` VARCHAR(50)      DEFAULT NULL,
  `start` DATE     NOT NULL,
  `end` DATE     NOT NULL,

  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  DEFAULT CHARSET = utf8;



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
