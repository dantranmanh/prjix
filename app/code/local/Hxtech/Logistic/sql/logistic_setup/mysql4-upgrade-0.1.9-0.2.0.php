<?php
$installer = $this;
$installer->startSetup();
$installer->run("
	ALTER TABLE {$this->getTable('sales/quote')} ADD `logistic_id` SMALLINT(6) DEFAULT 0;
	ALTER TABLE {$this->getTable('sales/order')} ADD `logistic_id` SMALLINT(6) DEFAULT 0;
	ALTER TABLE {$this->getTable('sales/quote')} ADD `commission_fee` DECIMAL(12,2) DEFAULT 0;
	ALTER TABLE {$this->getTable('sales/order')} ADD `commission_fee` DECIMAL(12,2) DEFAULT 0;
");
$installer->endSetup();