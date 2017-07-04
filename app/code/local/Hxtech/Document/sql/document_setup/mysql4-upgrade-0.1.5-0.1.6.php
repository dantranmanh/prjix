<?php

$installer = $this;
$installer->startSetup();

$installer->run("
ALTER TABLE {$this->getTable('document_info')} ADD `exporting_country` TEXT DEFAULT '';
ALTER TABLE {$this->getTable('document_info')} ADD `importing_country` TEXT DEFAULT '';
");

$installer->endSetup(); 