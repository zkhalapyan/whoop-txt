SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `whoop_txt_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `whoop_txt_db` ;

-- -----------------------------------------------------
-- Table `whoop_txt_db`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `whoop_txt_db`.`users` (
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
-- Table `whoop_txt_db`.`messages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `whoop_txt_db`.`messages` (
  `id` INT NOT NULL ,
  `text` VARCHAR(256) NULL ,
  `post_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `whoop_txt_db`.`tokens`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `whoop_txt_db`.`tokens` (
  `id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `whoop_txt_db`.`tokens_users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `whoop_txt_db`.`tokens_users` (
  `id` INT NOT NULL ,
  `tokens_id` INT NOT NULL ,
  `users_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `tokens_id`, `users_id`) ,
  INDEX `fk_tokens_users_tokens` (`tokens_id` ASC) ,
  INDEX `fk_tokens_users_users1` (`users_id` ASC) ,
  CONSTRAINT `fk_tokens_users_tokens`
    FOREIGN KEY (`tokens_id` )
    REFERENCES `whoop_txt_db`.`tokens` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tokens_users_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `whoop_txt_db`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `whoop_txt_db`.`messages_users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `whoop_txt_db`.`messages_users` (
  `id` INT NOT NULL ,
  `messages_id` INT NOT NULL ,
  `users_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `messages_id`, `users_id`) ,
  INDEX `fk_messages_users_messages1` (`messages_id` ASC) ,
  INDEX `fk_messages_users_users1` (`users_id` ASC) ,
  CONSTRAINT `fk_messages_users_messages1`
    FOREIGN KEY (`messages_id` )
    REFERENCES `whoop_txt_db`.`messages` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_messages_users_users1`
    FOREIGN KEY (`users_id` )
    REFERENCES `whoop_txt_db`.`users` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `whoop_txt_db`.`message_token`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `whoop_txt_db`.`message_token` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `messages_id` INT NOT NULL ,
  `tokens_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `messages_id`, `tokens_id`) ,
  INDEX `fk_message_token_messages1` (`messages_id` ASC) ,
  INDEX `fk_message_token_tokens1` (`tokens_id` ASC) ,
  CONSTRAINT `fk_message_token_messages1`
    FOREIGN KEY (`messages_id` )
    REFERENCES `whoop_txt_db`.`messages` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_message_token_tokens1`
    FOREIGN KEY (`tokens_id` )
    REFERENCES `whoop_txt_db`.`tokens` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `whoop_txt_db`.`location`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `whoop_txt_db`.`location` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `longitude` VARCHAR(45) NULL ,
  `latitude` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `whoop_txt_db`.`message_location`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `whoop_txt_db`.`message_location` (
  `id` INT NOT NULL ,
  `location_id` INT NOT NULL ,
  `messages_id` INT NOT NULL ,
  PRIMARY KEY (`id`, `location_id`, `messages_id`) ,
  INDEX `fk_message_location_location1` (`location_id` ASC) ,
  INDEX `fk_message_location_messages1` (`messages_id` ASC) ,
  CONSTRAINT `fk_message_location_location1`
    FOREIGN KEY (`location_id` )
    REFERENCES `whoop_txt_db`.`location` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_message_location_messages1`
    FOREIGN KEY (`messages_id` )
    REFERENCES `whoop_txt_db`.`messages` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
