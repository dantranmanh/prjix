<?php

$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `admin_user` ADD `commission_fixed_fee` DECIMAL(12,2) NOT NULL DEFAULT '0' ;
ALTER TABLE `admin_user` ADD `commission_percentage_fee` DECIMAL(12,2) NOT NULL DEFAULT '0' ;
");

$installer->endSetup();