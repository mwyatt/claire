CREATE TABLE `shop_stock_reminder` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`product_id` INT(11) UNSIGNED NULL DEFAULT '0' COMMENT 'product which customer needs reminding about',
	`email` VARCHAR(254) NULL DEFAULT '' COMMENT 'customers email address',
	`time_created` INT(11) NOT NULL DEFAULT '0' COMMENT 'epoch of when the row was created',
	PRIMARY KEY (`id`)
)
COMMENT='holds a list of email addresses which will be periodically removed using a cron task when the product becomes in stock.'
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;
