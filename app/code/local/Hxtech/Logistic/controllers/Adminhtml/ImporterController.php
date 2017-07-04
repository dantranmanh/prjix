<?php

class Hxtech_Logistic_Adminhtml_ImporterController extends Mage_Adminhtml_Controller_Action
{
    public function orderTabAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('importer.edit.tab.order')
            ->setOrders($this->getRequest()->getPost('oorder', null));
        $this->renderLayout();
    }
}