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
CREATE TABLE IF NOT EXISTS `{$installer->getTable('safemage_permissions/config')}` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `store_ids` text NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `safemage_permissions_config_ibfk_1`
    FOREIGN KEY (`role_id`)
    REFERENCES `{$installer->getTable('admin/role')}` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

CREATE TABLE IF NOT EXISTS `{$installer->getTable('safemage_permissions/config_group')}` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `config_id` varchar(500) NOT NULL,
  `permission` tinyint(4) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `permission` (`permission`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `safemage_permissions_config_group_ibfk_1`
    FOREIGN KEY (`role_id`)
    REFERENCES `{$installer->getTable('admin/role')}` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

");

$installer->getConnection()->resetDdlCache();
$installer->endSetup();
