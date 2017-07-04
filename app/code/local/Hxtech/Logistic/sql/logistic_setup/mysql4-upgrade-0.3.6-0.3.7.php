<?php

$installer = $this;
$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId     = $setup->getEntityTypeId('customer_address');
$attributeSetId   = $setup->getDefaultAttributeSetId($entityTypeId);
$attributeGroupId = $setup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);

$setup->addAttribute('customer_address', 'closestport_name', array(
    'input'         => 'text',
    'type'          => 'varchar',
    'label'         => 'Closest Port',
    'visible'       => 1,
    'required'      => 1, 
    'user_defined' => 1,
));

$oAttributea = Mage::getSingleton('eav/config')->getAttribute('customer_address', 'closestport_name');
$oAttributea->setData('used_in_forms', array('customer_register_address','customer_address_edit','adminhtml_customer_address'));
$oAttributea->save();

$setup->endSetup();