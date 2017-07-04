<?php

$installer = $this;
$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('logistic_country_port')};
CREATE TABLE {$this->getTable('logistic_country_port')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `country_code` varchar(250) NOT NULL default '',
  `port` varchar(250) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 