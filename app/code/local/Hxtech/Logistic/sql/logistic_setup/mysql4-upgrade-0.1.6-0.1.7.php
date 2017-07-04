<?php
$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `admin_user` ADD `company_position` VARCHAR(255) DEFAULT '';
ALTER TABLE `admin_user` ADD `telephone` VARCHAR(50) DEFAULT '';
ALTER TABLE `admin_user` ADD `bank_account_number` VARCHAR(50) DEFAULT '';
ALTER TABLE `admin_user` ADD `sort_code` VARCHAR(125) DEFAULT '';
");

$installer->endSetup();