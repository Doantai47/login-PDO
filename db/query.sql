CREATE DATABASE `qsoft_training_php`
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE `qsoft_training_php`;

CREATE TABLE  `users` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`email` VARCHAR( 100 ) NOT NULL ,
	`password` VARCHAR( 100 ) NOT NULL 
) ENGINE = INNODB;

INSERT INTO `qsoft_training_php`.`users` (`id`, `email`, `password`) VALUES ('1', 'admin@qsoftvietnam.com', MD5('Qsoftvietnam2015'));
INSERT INTO `qsoft_training_php`.`users` (`id`, `email`, `password`) VALUES ('2', 'user1@qsoftvietnam.com', MD5('Qsoftvietnam2014'));
INSERT INTO `qsoft_training_php`.`users` (`id`, `email`, `password`) VALUES ('3', 'user2@qsoftvietnam.com', MD5('Qsoftvietnam2013'));
INSERT INTO `qsoft_training_php`.`users` (`id`, `email`, `password`) VALUES ('4', 'user3@qsoftvietnam.com', MD5('Qsoftvietnam2012'));