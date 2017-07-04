<?php
/*
* @copyright   Copyright (c) 2014 www.magebuzz.com
*/

$installer = $this;
$installer->startSetup();
$installer->run("
ALTER TABLE {$this->getTable('product_alert_stock')} ADD `firstname` varchar(30);
ALTER TABLE {$this->getTable('product_alert_stock')} ADD `lastname` varchar(30);
ALTER TABLE {$this->getTable('product_alert_stock')} ADD `email` varchar(50);
ALTER TABLE {$this->getTable('product_alert_stock')} DROP FOREIGN KEY `FK_PRODUCT_ALERT_STOCK_CUSTOMER_ID_CUSTOMER_ENTITY_ENTITY_ID`;	
    ");
$installer->endSetup(); 
