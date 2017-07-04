<?php
$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `logistic_shippingrate`
	DROP COLUMN `customs_clearance`,
	DROP COLUMN `aqis_clearance`,
	DROP COLUMN `australian_port_charges`,
	DROP COLUMN `other_fees`;
");

$installer->endSetup();