SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users` ;

CREATE  TABLE IF NOT EXISTS `users` (
  `id` INT NOT NULL ,
  `full_name` VARCHAR(45) NULL ,
  `access_token` VARCHAR(256) NULL ,
  `access_time` VARCHAR(45) NULL ,
  `create_time` VARCHAR(45) NULL ,
  `registered` TINYINT(1)  NULL ,
  `deleted` TINYINT(1)  NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `messages` ;

CREATE  TABLE IF NOT EXISTS `messages` (
  `id` INT NOT NULL ,
  `text` VARCHAR(256) NULL ,
  `post_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `token_names`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `token_names` ;

CREATE  TABLE IF NOT EXISTS `token_names` (
  `id` INT NOT NULL ,
  `name` VARCHAR(256) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `token`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `token` ;

CREATE  TABLE IF NOT EXISTS `token` (
  `id` INT NOT NULL ,
  `token_names_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `token_names_id`) ,
  INDEX `fk_token_token_names1` (`token_names_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tokens_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tokens_users` ;

CREATE  TABLE IF NOT EXISTS `tokens_users` (
  `id` INT NOT NULL ,
  `tokens_names_id` INT NOT NULL ,
  `users_id` INT NOT NULL ,
  `deleted` BIT NULL ,
  PRIMARY KEY (`id`, `tokens_names_id`, `users_id`) ,
  INDEX `fk_tokens_users_tokens` (`tokens_names_id` ASC) ,
  INDEX `fk_tokens_users_users1` (`users_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `token_messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `token_messages` ;

CREATE  TABLE IF NOT EXISTS `token_messages` (
  `id` INT NOT NULL ,
  `messages_id` INT NOT NULL ,
  `token_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `messages_id`, `token_id`) ,
  INDEX `fk_messages_users_messages1` (`messages_id` ASC) ,
  INDEX `fk_messages_users_token1` (`token_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `location`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `location` ;

CREATE  TABLE IF NOT EXISTS `location` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `longitude` VARCHAR(45) NULL ,
  `latitude` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `message_locations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `message_locations` ;

CREATE  TABLE IF NOT EXISTS `message_locations` (
  `id` INT NOT NULL ,
  `location_id` INT NOT NULL ,
  `messages_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `location_id`, `messages_id`) ,
  INDEX `fk_message_location_location1` (`location_id` ASC) ,
  INDEX `fk_message_location_messages1` (`messages_id` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_messages` ;

CREATE  TABLE IF NOT EXISTS `user_messages` (
  `id` INT NOT NULL ,
  `users_id` INT NOT NULL ,
  `messages_id` INT NOT NULL ,
  `read` BIT NULL ,
  `deleted` BIT NULL ,
  `important` BIT NULL ,
  PRIMARY KEY (`id`, `users_id`, `messages_id`) ,
  INDEX `fk_user_messages_users1` (`users_id` ASC) ,
  INDEX `fk_user_messages_messages1` (`messages_id` ASC) )
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
