<?php

$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `admin_user` ADD `company` VARCHAR(220) DEFAULT '';
ALTER TABLE `admin_user` ADD `street` TEXT DEFAULT '';
ALTER TABLE `admin_user` ADD `city` VARCHAR(220) DEFAULT '';
ALTER TABLE `admin_user` ADD `country_id` VARCHAR(50) DEFAULT '';
ALTER TABLE `admin_user` ADD `region` VARCHAR(220) DEFAULT '';
ALTER TABLE `admin_user` ADD `region_id` VARCHAR(30) DEFAULT '';
ALTER TABLE `admin_user` ADD `postcode` VARCHAR(50) DEFAULT '';
ALTER TABLE `admin_user` ADD `website` VARCHAR(220) DEFAULT '';
ALTER TABLE `admin_user` ADD `vat_id` VARCHAR(220) DEFAULT '';
");

$installer->endSetup();