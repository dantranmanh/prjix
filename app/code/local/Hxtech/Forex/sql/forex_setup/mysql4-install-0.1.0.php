<?php

$installer = $this;
$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('forex_financier')};
CREATE TABLE {$this->getTable('forex_financier')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(125) NOT NULL,
  `logo` varchar(255) NOT NULL default '',
  `email` varchar(125) NOT NULL default '',
  `description` TEXT NOT NULL default '',
  `commission_fixed_fee` decimal(12,2) NOT NULL default 0,
  `commission_percentage_fee` decimal(12,2) NOT NULL default 0,
  `commission_type` smallint(6) NOT NULL default 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 