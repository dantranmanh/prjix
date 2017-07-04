<?php

$installer = $this;

$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$entityTypeId     = $setup->getEntityTypeId('customer');
$attributeSetId   = $setup->getDefaultAttributeSetId($entityTypeId);
$attributeGroupId = $setup->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);

$installer->addAttribute("customer", "preferred_currency",  array(
    "type"     => "varchar",
    "backend"  => "",
    "label"    => "Preferred Trading Currency",
    "input"    => "select",
    "source"   => "forex/source_option",
    "visible"  => true,
    "required" => true,
    "default" => "",
    "frontend" => "",
    "unique"     => false,
));

$attribute   = Mage::getSingleton("eav/config")->getAttribute("customer", "preferred_currency");

$setup->addAttributeToGroup(
    $entityTypeId,
    $attributeSetId,
    $attributeGroupId,
    'preferred_currency',
    '999'  //sort_order
);

$used_in_forms=array();

$used_in_forms[]="adminhtml_customer";
$attribute->setData("used_in_forms", $used_in_forms)
        ->setData("is_used_for_customer_segment", true)
        ->setData("is_system", 0)
        ->setData("is_user_defined", 1)
        ->setData("is_visible", 1)
        ->setData("sort_order", 100)
        ;
$attribute->save();

$installer->endSetup();