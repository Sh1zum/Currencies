CREATE TABLE `currencies` (
                              `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
                              `code` varchar(5) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
                              `mid` float NOT NULL,
                              PRIMARY KEY (`code`)
)

CREATE TABLE `test`.`exchanges` (
                                    `source_code` VARCHAR(45) NOT NULL,
                                    `destination_code` VARCHAR(45) NOT NULL,
                                    `amount` FLOAT NOT NULL,
                                    `rate` FLOAT NOT NULL,
                                    `date` DATE NOT NULL,
                                    `id` INT NOT NULL AUTO_INCREMENT,
                                    PRIMARY KEY (`id`),
                                    FOREIGN KEY (source_code) REFERENCES currencies(code),
                                    FOREIGN KEY (destination_code) REFERENCES currencies(code)
)
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;

