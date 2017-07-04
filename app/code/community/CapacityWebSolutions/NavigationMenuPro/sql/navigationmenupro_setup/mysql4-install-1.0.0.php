<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
$installer = $this;

$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('menucreatorgroup')};
CREATE TABLE IF NOT EXISTS {$this->getTable('menucreatorgroup')} (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `titletextcolor` varchar(255) DEFAULT NULL,
  `titlebackcolor` varchar(255) DEFAULT NULL,
  `showhidetitle` smallint(6) NOT NULL DEFAULT '1',
  `description` text NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  `menutype` varchar(255) NOT NULL,
  `menubgcolor` varchar(255) DEFAULT NULL,
  `itemtextcolor` varchar(255) DEFAULT NULL,
  `itemtexthovercolor` varchar(255) DEFAULT NULL,
  `itembgcolor` varchar(255) DEFAULT NULL,
  `itembghovercolor` varchar(255) DEFAULT NULL,
  `alignment` varchar(255) DEFAULT 'left',
  `level` varchar(255) NOT NULL,
  `position` varchar(255) DEFAULT '1' ,
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  `show_hide_title` smallint(6) NOT NULL DEFAULT '1',
  `image_height` smallint(6) NOT NULL DEFAULT '25',
  `image_width` smallint(6) NOT NULL DEFAULT '25',
  `arrowcolor` varchar(255) DEFAULT NULL,
  `rootactivecolor` varchar(255) DEFAULT NULL,
  `subitemsbgcolor` varchar(255) DEFAULT NULL,
  `subitemsbordercolor` varchar(255) DEFAULT NULL,
  `megaparenttextcolor` varchar(255) DEFAULT NULL,
  `megaparenttexthovercolor` varchar(255) DEFAULT NULL,
  `megaparenttextactivecolor` varchar(255) DEFAULT NULL,
  `megaparenttextbgcolor` varchar(255) DEFAULT NULL,
  `megaparenttextbghovercolor` varchar(255) DEFAULT NULL,
  `subitemtextcolor` varchar(255) DEFAULT NULL,
  `subitemtexthovercolor` varchar(255) DEFAULT NULL,
  `itemactivecolor` varchar(255) DEFAULT NULL,
  `subitembgcolor` varchar(255) DEFAULT NULL,
  `subitembghovercolor` varchar(255) DEFAULT NULL,
  `subitemdividercolor` varchar(255) DEFAULT NULL,
  `dividercolor` varchar(255) DEFAULT NULL,  
  `subarrowcolor` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS {$this->getTable('menucreator')} (
	`menu_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`group_id` int(11) unsigned NOT NULL,
	`title` varchar(255) NOT NULL DEFAULT '',
	`description` text NOT NULL,
	`image` text NOT NULL,
	`type` text NOT NULL,
	`category_id` varchar(6) NOT NULL DEFAULT '',
	`cmspage_identifier` varchar(255) NOT NULL DEFAULT '',
	`staticblock_identifier` varchar(255) NOT NULL DEFAULT '',
	`product_id` varchar(6) NOT NULL DEFAULT '',
	`parent_id` varchar(6) NOT NULL DEFAULT '',
	`url_value` varchar(255) NOT NULL DEFAULT '',
	`usedlink_identifier` varchar(255) NOT NULL DEFAULT '',
	`image_status` smallint(6) NOT NULL DEFAULT '1',
	`show_category_image` varchar(255),
	`position` smallint(6) NOT NULL DEFAULT '-1',
	`class_subfix` text NOT NULL,
	`permission` varchar(500) NOT NULL DEFAULT '-1',
	`status` smallint(6) NOT NULL DEFAULT '1',
	`created_time` datetime DEFAULT NULL,
	`update_time` datetime DEFAULT NULL,
	`target` smallint(6) DEFAULT 1,
	`storeids` varchar(250),
	`autosub` smallint(6),
	`use_category_title` VARCHAR(5) DEFAULT 2,
	`autosubimage` VARCHAR(5) DEFAULT 0,
	`text_align` VARCHAR(255) DEFAULT 'left',
	`image_type` VARCHAR(255) DEFAULT 'none',
	`subcolumnlayout` varchar(255) DEFAULT NULL,
	`title_show_hide` varchar(255) DEFAULT NULL,
	PRIMARY KEY (menu_id),
	FOREIGN KEY (group_id) REFERENCES menucreatorgroup(group_id)
)ENGINE=MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci AUTO_INCREMENT=0 ;
");

$installer->endSetup(); 


