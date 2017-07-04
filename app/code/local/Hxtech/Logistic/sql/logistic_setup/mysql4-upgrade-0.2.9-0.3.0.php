<?php

$installer = $this;
$installer->startSetup();

$installer->run("
	
ALTER TABLE {$this->getTable('sales/quote')} ADD `importer_commission_type` SMALLINT(6) DEFAULT 0;
ALTER TABLE {$this->getTable('sales/order')} ADD `importer_commission_type` SMALLINT(6) DEFAULT 0;

ALTER TABLE {$this->getTable('sales/quote')} ADD `importer_commission_fee` DECIMAL(12,2) DEFAULT 0;
ALTER TABLE {$this->getTable('sales/order')} ADD `importer_commission_fee` DECIMAL(12,2) DEFAULT 0;

");

$installer->endSetup();