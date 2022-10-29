SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `bank_api_setup`;
CREATE TABLE `bank_api_setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` text NOT NULL,
  `value` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `bank_api_setup` (`id`, `key`, `value`) VALUES
(1,	'access',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.6WyIwLjAuMC4wLzAiLCI6Oi8wIl19F9jaWRycyI6WyIwLjAuMC4wLzAiLCI6Oi8wIl19.WyIwLjAuMC4wLzAiLCI6Oi8wIl19Me2pUzuwiPnhyp0'),
(2,	'access_expires',	'86400'),
(3,	'refresh',	'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.6WyIwLjAuMC4wLzAiLCI6Oi8wIl19F9jaWRycyI6WyIwLjAuMC4wLzAiLCI6Oi8wIl19.Y9Ik4BlaYptdbAmq53-W8j4i0X8Ea4bbplrrLJBr-pI'),
(4,	'refresh_expires',	'25678'),
(5,	'institution_id',	'KSK_BERLIN_SO...'),
(6,	'account_id',	'677f17cb40'),
(7,	'secret_id',	'677f17cb40'),
(8,	'secret_key',	'677f17cb40'),
(9,	'reference',	'677f17cb40'),
(10,	'bank_api_base_url',	'https://ob.nordigen.com/api/v2/'),
(11,	'ckey',	'sAWtS677f17cb40DcVKg');

DROP TABLE IF EXISTS `ip_transactions`;
CREATE TABLE `ip_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transactionId` varchar(255) NOT NULL,
  `bookingDate` date DEFAULT NULL,
  `valueDate` date DEFAULT NULL,
  `transactionAmount` double DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `iban` varchar(255) DEFAULT NULL,
  `remittanceInformationStructured` text,
  `additionalInformation` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `ip_transaction_files`;
CREATE TABLE `ip_transaction_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `full_path` varchar(255) NOT NULL,
  `raw_name` varchar(255) NOT NULL,
  `file_ext` varchar(255) NOT NULL,
  `file_size` double NOT NULL,
  `transactionId` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2022-10-29 23:10:02