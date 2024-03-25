SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- doofinder_excluded_product
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `doofinder_excluded_product`;

CREATE TABLE `doofinder_excluded_product`
(
    `product_id` INTEGER NOT NULL,
    `created_at` DATETIME,
    `updated_at` DATETIME,
    PRIMARY KEY (`product_id`),
    CONSTRAINT `fk_product_id`
        FOREIGN KEY (`product_id`)
            REFERENCES `product` (`id`)
            ON UPDATE RESTRICT
            ON DELETE CASCADE
) ENGINE=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;
