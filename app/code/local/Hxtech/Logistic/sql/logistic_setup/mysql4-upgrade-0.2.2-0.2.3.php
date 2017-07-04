<?php

$installer = $this;
$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('logistic_tier_commission')};
CREATE TABLE {$this->getTable('logistic_tier_commission')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `logistic_user_id` int(11) NOT NULL,
  `cust_group` int(10) NOT NULL,
  `price_min` decimal(12,2) NOT NULL,
  `price_max` decimal(12,2) NOT NULL,
  `percentage` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 