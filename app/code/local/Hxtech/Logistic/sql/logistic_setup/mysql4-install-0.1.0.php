<?php
$installer = $this;
$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('logistic_shippingrate')};
CREATE TABLE {$this->getTable('logistic_shippingrate')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `logistic_user_id` int(11) NOT NULL,
  `reference_id` varchar(25) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `name_of_service` varchar(50) NOT NULL default '',
  `container_size` varchar(50) NOT NULL default '',
  `shipping_terms` varchar(50) NOT NULL default '',
  `transport_method` varchar(50) NOT NULL default '',
  `origin_port` varchar(50) NOT NULL default '',
  `destination_port` varchar(50) NOT NULL default '',
  `transit_time` varchar(50) NOT NULL default '',
  `price_cbm` decimal(12,2) NOT NULL default 0,
  `documentation_fee` decimal(12,2) NOT NULL default 0,
  `customs_clearance` decimal(12,2) NOT NULL default 0,
  `aqis_clearance` decimal(12,2) NOT NULL default 0,
  `australian_port_charges` decimal(12,2) NOT NULL default 0,
  `other_fees` decimal(12,2) NOT NULL default 0,
  `container_specifications` varchar(50) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 