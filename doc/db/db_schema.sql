SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users` ;

CREATE  TABLE IF NOT EXISTS `users` (
  `id` BIGINT UNSIGNED NOT NULL ,
  `full_name` VARCHAR(256) NOT NULL ,
  `email` VARCHAR(256) NULL ,
  `access_token` VARCHAR(256) NULL ,
  `access_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
  `create_time` DATETIME NOT NULL ,
  `locale` VARCHAR(45) NULL ,
  `gender` VARCHAR(8) NULL ,
  `active` TINYINT(1)  NOT NULL ,
  `friends_count` INT NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `messages` ;

CREATE  TABLE IF NOT EXISTS `messages` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `author_id` BIGINT UNSIGNED NOT NULL ,
  `text` VARCHAR(256) NOT NULL ,
  `post_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`, `author_id`) ,
  INDEX `fk_messages_users1` (`author_id` ASC) ,
  CONSTRAINT `fk_messages_users1`
    FOREIGN KEY (`author_id` )
    REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `token_names`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `token_names` ;

CREATE  TABLE IF NOT EXISTS `token_names` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(256) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tokens`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tokens` ;

CREATE  TABLE IF NOT EXISTS `tokens` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `token_names_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `token_names_id`) ,
  INDEX `fk_token_token_names1` (`token_names_id` ASC) ,
  CONSTRAINT `fk_token_token_names1`
    FOREIGN KEY (`token_names_id` )
    REFERENCES `token_names` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `tokens_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `tokens_users` ;

CREATE  TABLE IF NOT EXISTS `tokens_users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `tokens_id` INT NOT NULL ,
  `users_id` BIGINT UNSIGNED NOT NULL ,
  `active` TINYINT(1)  NOT NULL ,
  `pending` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`id`, `tokens_id`, `users_id`) ,
  INDEX `fk_tokens_users_tokens` (`tokens_id` ASC) ,
  INDEX `fk_tokens_users_users1` (`users_id` ASC) ,
  CONSTRAINT `fk_tokens_users_tokens`
    FOREIGN KEY (`tokens_id` )
    REFERENCES `tokens` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tokens_users_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `token_messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `token_messages` ;

CREATE  TABLE IF NOT EXISTS `token_messages` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `messages_id` INT NOT NULL ,
  `token_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `messages_id`, `token_id`) ,
  INDEX `fk_messages_users_messages1` (`messages_id` ASC) ,
  INDEX `fk_messages_users_token1` (`token_id` ASC) ,
  CONSTRAINT `fk_messages_users_messages1`
    FOREIGN KEY (`messages_id` )
    REFERENCES `messages` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_users_token1`
    FOREIGN KEY (`token_id` )
    REFERENCES `tokens` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `locations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `locations` ;

CREATE  TABLE IF NOT EXISTS `locations` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `longitude` DOUBLE NOT NULL ,
  `latitude` DOUBLE NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `message_locations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `message_locations` ;

CREATE  TABLE IF NOT EXISTS `message_locations` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `location_id` INT NOT NULL ,
  `messages_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `location_id`, `messages_id`) ,
  INDEX `fk_message_location_location1` (`location_id` ASC) ,
  INDEX `fk_message_location_messages1` (`messages_id` ASC) ,
  CONSTRAINT `fk_message_location_location1`
    FOREIGN KEY (`location_id` )
    REFERENCES `locations` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_message_location_messages1`
    FOREIGN KEY (`messages_id` )
    REFERENCES `messages` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `user_messages` ;

CREATE  TABLE IF NOT EXISTS `user_messages` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `users_id` BIGINT UNSIGNED NOT NULL ,
  `messages_id` INT NOT NULL ,
  `opened` TINYINT(1)  NOT NULL DEFAULT false ,
  `deleted` TINYINT(1)  NOT NULL DEFAULT false ,
  `important` TINYINT(1)  NOT NULL DEFAULT false ,
  PRIMARY KEY (`id`, `users_id`, `messages_id`) ,
  INDEX `fk_user_messages_users1` (`users_id` ASC) ,
  INDEX `fk_user_messages_messages1` (`messages_id` ASC) ,
  CONSTRAINT `fk_user_messages_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_messages_messages1`
    FOREIGN KEY (`messages_id` )
    REFERENCES `messages` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
