<?php

class Hxtech_Logistic_Adminhtml_PalletController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()->renderLayout();
    }

    protected function _isAllowed(){
        return true;
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('logistic/pallet');

        if ($id) {
            $model->load($id);
            $data = Mage::getSingleton('adminhtml/session')->getFormData(TRUE);
            if (!empty($data)) {
                $model->setData($data);
            }
        }
        Mage::register('pallet_data', $model);
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('logistic/adminhtml_pallet_edit'))->_addLeft($this->getLayout()->createBlock('logistic/adminhtml_pallet_edit_tabs'));

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
            $model = Mage::getModel('logistic/pallet')->load($id);
            $model->addData($data);
            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The pallet information has been saved successfully.'));

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
                $model = Mage::getModel('logistic/pallet');
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

    public function massDeleteAction()
    {
        $palletIds = $this->getRequest()->getParam('pallet');
        if (!is_array($palletIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($palletIds as $palletId) {
                    $pallet = Mage::getModel('logistic/pallet')->load($palletId);
                    $pallet->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($palletIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
}