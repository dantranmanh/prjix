<?php

$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `admin_user` ADD `document_fixed_cost_rate` DECIMAL(12,2) NOT NULL DEFAULT '0' ;
");

$installer->endSetup();