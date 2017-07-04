<?php
$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `logistic_shippingrate` ADD `destination_country` VARCHAR(255) DEFAULT '' ;
");

$installer->endSetup();