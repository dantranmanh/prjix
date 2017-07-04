<?php

class Hxtech_Logistic_Adminhtml_PortController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('logistic/items')->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

        return $this;
    }

    public function indexAction()
    {
        $this->_initAction()->renderLayout();
    }

    protected function _isAllowed(){
        return true;
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('logistic/port');

        if ($id) {
            $model->load($id);
            $data = Mage::getSingleton('adminhtml/session')->getFormData(TRUE);
            if (!empty($data)) {
                $model->setData($data);
            }
        }
        Mage::register('port_data', $model);
        $this->loadLayout();

        $this->_addContent($this->getLayout()->createBlock('logistic/adminhtml_import_port_edit'))->_addLeft($this->getLayout()->createBlock('logistic/adminhtml_import_port_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_redirect('*/*/edit');
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('logistic/port')->load($id);
            $model->setCountryCode($data['country_code']);
            $model->setPort($data['port']);
            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The port has been saved successfully.'));

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('logistic/port');

                $model->setId($this->getRequest()->getParam('id'))->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function reloadClosestPortAdminByCountryAction()
    {
        $result = array();
        $countryId = $this->getRequest()->getParam('countryId');
        $currentClosestPort = $this->getRequest()->getParam('currentClosestPort');
        $collection = Mage::getModel('logistic/port')->getCollection();
        $collection->addFieldToFilter('country_code', $countryId);
        
        $html = Mage::helper('logistic/port')->getClosestPortHtml($collection, $currentClosestPort);

        $result['html'] = $html;
        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}