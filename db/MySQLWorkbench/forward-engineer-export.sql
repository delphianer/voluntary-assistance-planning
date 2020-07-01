-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema vokuro
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema vokuro
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `vokuro` DEFAULT CHARACTER SET utf8mb4 ;
USE `vokuro` ;

-- -----------------------------------------------------
-- Table `vokuro`.`equipment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vokuro`.`equipment` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `desc_short` VARCHAR(60) NULL,
  `desc_long` VARCHAR(500) NULL,
  `total_count` INT UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `desc_short_UNIQUE` (`desc_short` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vokuro`.`volunteers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vokuro`.`volunteers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `firstName` VARCHAR(60) NULL,
  `lastName` VARCHAR(60) NULL,
  `userId` INT NULL,
  `departmentId` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `userId_UNIQUE` (`userId` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vokuro`.`certificates`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vokuro`.`certificates` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `desc_short` VARCHAR(60) UNIQUE NULL,
  `desc_long` VARCHAR(60) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vokuro`.`volunteers_certificates_link`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vokuro`.`volunteers_certificates_link` (
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `volunteersId` INT NOT NULL,
  `certificatesId` INT NOT NULL,
  `validUntil` DATE NULL,
  INDEX `FKVolunteers_idx` (`volunteersId` ASC) ,
  INDEX `FKCertificates_idx` (`certificatesId` ASC) ,
  PRIMARY KEY (`volunteersId`, `certificatesId`),
  CONSTRAINT `FKVolunteers`
    FOREIGN KEY (`volunteersId`)
    REFERENCES `vokuro`.`volunteers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FKCertificates`
    FOREIGN KEY (`certificatesId`)
    REFERENCES `vokuro`.`certificates` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vokuro`.`vehicles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vokuro`.`vehicles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `desc_short` VARCHAR(60) UNIQUE NOT NULL,
  `desc_long` VARCHAR(500) NULL,
  `technicalInspection` DATE NULL,
  `seatCount` INT NOT NULL DEFAULT 0,
  `isAmbulance` VARCHAR(1) NOT NULL DEFAULT 'N',
  `hasFlashingLights` VARCHAR(1) NOT NULL DEFAULT 'N',
  `hasRadioCom` VARCHAR(1) NOT NULL,
  `hasDigitalRadioCom` VARCHAR(1) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vokuro`.`departments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vokuro`.`departments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `desc_short` VARCHAR(60) UNIQUE NULL,
  `desc_long` VARCHAR(500) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vokuro`.`vehicleProperties`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vokuro`.`vehicleProperties` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `vehiclesId` INT NOT NULL,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `desc_short` VARCHAR(60) UNIQUE NULL,
  `desc_long` VARCHAR(500) NULL,
  `is_numeric` VARCHAR(1) NOT NULL DEFAULT 'N',
  `value_string` VARCHAR(500) NULL,
  `value_numeric` DECIMAL(12,5) NULL,
  PRIMARY KEY (`id`, `vehiclesId`),
  INDEX `FKVehicles_idx` (`vehiclesId` ASC) ,
  CONSTRAINT `FKVehicles`
    FOREIGN KEY (`vehiclesId`)
    REFERENCES `vokuro`.`vehicles` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vokuro`.`locations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vokuro`.`locations` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `desc_short` VARCHAR(60) UNIQUE NULL,
  `desc_long` VARCHAR(500) NULL,
  `street` VARCHAR(100) NULL,
  `additionalText` VARCHAR(100) NULL,
  `postalcode` VARCHAR(10) NULL,
  `city` VARCHAR(60) NULL,
  `country` VARCHAR(60) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `vokuro`.`clients`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vokuro`.`clients` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `desc_short` VARCHAR(60) UNIQUE NULL,
  `desc_long` VARCHAR(500) NULL,
  `contactInformation` VARCHAR(500) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
