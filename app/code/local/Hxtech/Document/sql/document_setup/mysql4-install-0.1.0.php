<?php
$installer = $this;
$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('document_info')};
CREATE TABLE {$this->getTable('document_info')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `document_user_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL default '0',
  `name_of_service` varchar(50) NOT NULL default '',
  `product_type` TEXT NOT NULL default '',
  `document_type` TEXT NOT NULL default '',
  `price` decimal(12,2) NOT NULL default 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 