<?php

$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `admin_user` ADD `term_status` SMALLINT(6) NOT NULL DEFAULT '0' ;
");
$installer->run("
ALTER TABLE `admin_user` ADD `term_time` timestamp NULL;
");

$installer->endSetup();