<?php
$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `logistic_shippingrate`
	DROP COLUMN `reference_id`
");

$installer->endSetup();