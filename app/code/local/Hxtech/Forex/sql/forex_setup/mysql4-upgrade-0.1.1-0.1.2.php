<?php 

$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE `forex_financier` ADD `email_template_id` smallint(6) DEFAULT 0 ;
");

$installer->endSetup();