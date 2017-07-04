<?php

$installer = $this;
$installer->startSetup();
$installer->run("
	ALTER TABLE {$this->getTable('logistic_tier_commission')} ADD `fixed_fee` DECIMAL(12,2) NOT NULL;
");
$installer->endSetup();