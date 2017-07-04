<?php

class Hxtech_Document_Adminhtml_DocumentationController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('document/items')->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

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
        $model = Mage::getModel('document/documentation');

        if ($id) {
            $model->load($id);
            $data = Mage::getSingleton('adminhtml/session')->getFormData(TRUE);
            if (!empty($data)) {
                $model->setData($data);
            }
        }
        Mage::register('documentation_data', $model);
        $this->loadLayout();
        $this->_setActiveMenu('document/items');

        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(TRUE);

        $this->_addContent($this->getLayout()->createBlock('document/adminhtml_documentation_edit'))->_addLeft($this->getLayout()->createBlock('document/adminhtml_documentation_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_redirect('*/*/edit');
    }

    public function saveAction()
    {
        $r = $this->getRequest();
        if ($data = $r->getPost()) {
            if(isset($data['selected_document'])){
                $data['document_user_id'] = $data['selected_document'][0];
            }

            if(Mage::helper('document')->isDocumentSupplierUser()){
                $data['document_user_id'] = Mage::getSingleton('admin/session')->getUser()->getId();
            }

            if(isset($data['product_type'])){
                $data['product_type'] = implode(",", $data['product_type']);
            }

            if(isset($data['document_type'])){
                $data['document_type'] = implode(",", $data['document_type']);
            }

            if(isset($data['exporting_country'])){
                $data['exporting_country'] = implode(",", $data['exporting_country']);
            }

            if(isset($data['importing_country'])){
                $data['importing_country'] = implode(",", $data['importing_country']);
            }

            $model = Mage::getModel('document/documentation');      
            if ($id = $this->getRequest()->getParam('id')) {
                $model->load($id);
                $model->setData($data)->setId($this->getRequest()->getParam('id'));
            }else{
                $model->setData($data);
            }

            try {
                $model->save();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Documentation was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(FALSE);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('document')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('document/documentation');

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
        $documentIds = $this->getRequest()->getParam('document');
        if (!is_array($documentIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($documentIds as $documentId) {
                    $document = Mage::getModel('document/documentation')->load($documentId);
                    $document->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($documentIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction()
    {
        $documentIds = $this->getRequest()->getParam('document');
        if (!is_array($documentIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($documentIds as $documentId) {
                    Mage::getSingleton('document/shippingrate')->load($documentId)->setStatus($this->getRequest()->getParam('status'))->setIsMassupdate(TRUE)->save();
                }
                $this->_getSession()->addSuccess($this->__('Total of %d record(s) were successfully updated', count($documentIds)));
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function documentTabAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('documentation.edit.tab.document')
            ->setDocuments($this->getRequest()->getPost('odocument', null));
        $this->renderLayout();
    }
}