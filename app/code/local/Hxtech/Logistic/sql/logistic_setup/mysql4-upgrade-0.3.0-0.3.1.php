<?php

$installer = $this;
$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('importer_commission_config')};
CREATE TABLE {$this->getTable('importer_commission_config')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `importer_user_id` int(11) NOT NULL,
  `commission_type` smallint(6) NOT NULL,
  `commission_fixed_fee` decimal(12,2) NOT NULL,
  `commission_percentage_fee` decimal(12,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 