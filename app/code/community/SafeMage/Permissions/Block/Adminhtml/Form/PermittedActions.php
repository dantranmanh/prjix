<?php
/*
NOTICE OF LICENSE

This source file is subject to the SafeMageEULA that is bundled with this package in the file LICENSE.txt.

It is also available at this URL: https://www.safemage.com/LICENSE_EULA.txt

Copyright (c)  SafeMage (https://www.safemage.com/)
*/

class SafeMage_Permissions_Block_Adminhtml_Form_PermittedActions extends Mage_Core_Block_Template
{
    protected $_actions = array('allow_create', 'allow_edit', 'allow_delete');

    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('safemage/permissions/form/permitted-actions.phtml');
    }
}
