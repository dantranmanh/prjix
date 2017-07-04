<?php

$installer = $this;
$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('logistic_review')};
CREATE TABLE {$this->getTable('logistic_review')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `logistic_user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `summary` TEXT NOT NULL default '',
  `review` TEXT NOT NULL default '',
  `number_star` smallint(6) NOT NULL default 0,
  `nickname` VARCHAR(125) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 