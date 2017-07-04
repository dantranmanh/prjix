<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$installer->run("
CREATE TABLE IF NOT EXISTS `{$installer->getTable('safemage_permissions/category')}` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `store_ids` text NOT NULL,
  `allow_access_to` tinyint(4) NOT NULL,
  `ids` text NOT NULL,
  `tabs` text NOT NULL,
  `allow_create` tinyint(4) NOT NULL DEFAULT '0',
  `allow_edit` tinyint(4) NOT NULL DEFAULT '0',
  `allow_delete` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `safemage_permissions_category_ibfk_1`
    FOREIGN KEY (`role_id`)
    REFERENCES `{$installer->getTable('admin/role')}` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('safemage_permissions/product')}` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `store_ids` text NOT NULL,
  `allow_access_to` tinyint(4) NOT NULL DEFAULT '0',
  `category_ids` text NOT NULL,
  `ids` text NOT NULL,
  `tabs` text NOT NULL,
  `allow_create` tinyint(4) NOT NULL DEFAULT '0',
  `allow_edit` tinyint(4) NOT NULL DEFAULT '0',
  `allow_delete` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `safemage_permissions_product_ibfk_1`
    FOREIGN KEY (`role_id`)
    REFERENCES `{$installer->getTable('admin/role')}` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('safemage_permissions/sale')}` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `store_ids` text NOT NULL,
  `allow_access_to` text NOT NULL,
  `allow_own_products_only` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `safemage_permissions_sale_ibfk_1`
    FOREIGN KEY (`role_id`)
    REFERENCES `{$installer->getTable('admin/role')}` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('safemage_permissions/customer')}` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `website_ids` text NOT NULL,
  `allow_create` tinyint(4) NOT NULL DEFAULT '0',
  `allow_edit` tinyint(4) NOT NULL DEFAULT '0',
  `allow_delete` tinyint(4) NOT NULL DEFAULT '0',
  `tabs` text NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `safemage_permissions_customer_ibfk_1`
    FOREIGN KEY (`role_id`)
    REFERENCES `{$installer->getTable('admin/role')}` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('safemage_permissions/attribute')}` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `attribute_id` smallint(5) unsigned NOT NULL,
  `entity_type_id` smallint(5) NOT NULL,
  `permission` tinyint(4) NOT NULL,
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `role_id_2` (`role_id`,`attribute_id`),
  KEY `role_id` (`role_id`,`attribute_id`,`permission`),
  KEY `attribute_id` (`attribute_id`),
  KEY `entity_type_id` (`entity_type_id`),
  CONSTRAINT `safemage_permissions_attribute_ibfk_1`
    FOREIGN KEY (`role_id`)
    REFERENCES `{$installer->getTable('admin/role')}` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `safemage_permissions_attribute_ibfk_2`
    FOREIGN KEY (`attribute_id`)
    REFERENCES `{$installer->getTable('eav/attribute')}` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1924 ;

");

$installer->getConnection()->resetDdlCache();
$installer->endSetup();