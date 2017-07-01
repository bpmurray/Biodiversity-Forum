SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+01:00";


--
-- Database: `dbregistration`
--
-- USE dbregistration;

--
-- Table: `settings`
--
DROP TABLE IF EXISTS settings;
CREATE TABLE IF NOT EXISTS `settings` (
  `id`        INT(11) NOT NULL AUTO_INCREMENT,
  `enddate`   DATE NOT NULL,
  `counter`   INT(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT into settings (enddate, counter) VALUES ('2017-06-13', 200);
  
--
-- Table: `transactions`
--
DROP TABLE IF EXISTS transactions;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id`        INT(11) NOT NULL AUTO_INCREMENT,
  `who`       VARCHAR(60) NOT NULL,
  `action`    VARCHAR(255) NOT NULL,
  `timestamp` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
  

--
-- Table: `users`
--
DROP TABLE IF EXISTS users;
CREATE TABLE IF NOT EXISTS `users` (
  `id`        INT(11) NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(50) NOT NULL,
  `surname`   VARCHAR(50) NOT NULL,
  `organisation` VARCHAR(60),
  `email`     VARCHAR(60) NOT NULL UNIQUE KEY,
  `password`  VARCHAR(255) NOT NULL,
  `salt`      VARCHAR(255) NOT NULL,
  `token`     VARCHAR(255) NOT NULL,
  `timestamp` DATETIME NOT NULL,
  `admin`     BOOLEAN DEFAULT FALSE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

