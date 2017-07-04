<?php

$installer = $this;
$installer->startSetup();
$installer->run("
	ALTER TABLE {$this->getTable('sales/quote')} ADD `document_commission_type` SMALLINT(6) DEFAULT 0;
	ALTER TABLE {$this->getTable('sales/order')} ADD `document_commission_type` SMALLINT(6) DEFAULT 0;
");
$installer->endSetup();