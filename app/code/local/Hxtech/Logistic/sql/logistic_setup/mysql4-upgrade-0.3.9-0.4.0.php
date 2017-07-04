<?php

$installer = $this;
$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('logistic_pallet')};
CREATE TABLE {$this->getTable('logistic_pallet')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `width` decimal(12,2) NOT NULL default 0,
  `length` decimal(12,2) NOT NULL default 0,
  `height` decimal(12,2) NOT NULL default 0,
  `number_fit_small_container` int(11) NOT NULL default 0,
  `number_fit_large_container` int(11) NOT NULL default 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 