<?php
$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `admin_user` ADD `is_document_user` SMALLINT(6) NOT NULL DEFAULT '0' ;
");

$installer->endSetup();