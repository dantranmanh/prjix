<?php

$installer = $this;
$installer->startSetup();
$installer->run("
	ALTER TABLE {$this->getTable('sales/quote')} ADD `document_fee` DECIMAL(12,2) DEFAULT 0;
	ALTER TABLE {$this->getTable('sales/order')} ADD `document_fee` DECIMAL(12,2) DEFAULT 0;
");
$installer->endSetup();