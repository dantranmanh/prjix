<?php
$installer = $this;
$installer->startSetup();
$installer->run("
	ALTER TABLE {$this->getTable('sales/quote')} ADD `shipping_rate_id` SMALLINT(6) DEFAULT 0;
	ALTER TABLE {$this->getTable('sales/order')} ADD `shipping_rate_id` SMALLINT(6) DEFAULT 0;
");
$installer->endSetup();