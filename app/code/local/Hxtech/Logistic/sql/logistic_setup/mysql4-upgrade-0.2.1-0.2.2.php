<?php

$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `admin_user` ADD `commission_type` SMALLINT(6) NOT NULL DEFAULT '0' ;
");

$installer->endSetup();