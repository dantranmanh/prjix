<?php

class Hxtech_Document_Adminhtml_SupplierController extends Mage_Adminhtml_Controller_Action
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
        return Mage::getSingleton('admin/session')->isAllowed('document/supplier');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('admin/user');

        if ($id) {
            $model->load($id);
            $data = Mage::getSingleton('adminhtml/session')->getFormData(TRUE);
            if (!empty($data)) {
                $model->setData($data);
            }
        }
        Mage::register('document_supplier_data', $model);
        $this->loadLayout();
        $this->_setActiveMenu('document/items');

        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(TRUE);

        $this->_addContent($this->getLayout()->createBlock('document/adminhtml_supplier_edit'))->_addLeft($this->getLayout()->createBlock('document/adminhtml_supplier_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_redirect('*/*/edit');
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            $data['is_document_user'] = 1;
            $data['is_active'] = 1;
            $id = $this->getRequest()->getParam('user_id');
            $model = Mage::getModel('admin/user')->load($id);

            if (isset($_FILES['logistic_logo']['name']) && $_FILES['logistic_logo']['name'] != '') {
                try {
                    //rename image in case image name has space
                    $image_name = $_FILES['logistic_logo']['name'];
                    $new_image_name = Mage::helper('logistic')->renameImage($image_name);

                    $uploader = new Varien_File_Uploader('logistic_logo');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(TRUE);
                    $uploader->setFilesDispersion(FALSE);

                    $path = Mage::getBaseDir('media') . DS . 'logistic' . DS . 'logo';
                    if (!is_dir($path)) {
                        mkdir($path, 0777, TRUE);
                    }

                    if (!file_exists($path . DS . $new_image_name)) {
                        $uploader->save($path, $new_image_name);
                    }
                } catch (Exception $e) {
                    Mage::getSingleton('admin/session')->addError($e->getMessage());
                }
                $data['logistic_logo'] = $new_image_name;
            }
            if (isset($data['logistic_logo']['delete']) && $data['logistic_logo']['delete'] == 1) {
                $data['logistic_logo'] = '';
            }  elseif ($model->getLogisticLogo()) {
                $data['logistic_logo'] = $model->getLogisticLogo();
            }

            //Validate current admin password
            $model->setData($data);
            /*
             * Unsetting new password and password confirmation if they are blank
             */
            if ($model->hasNewPassword() && $model->getNewPassword() === '') {
                $model->unsNewPassword();
            }
            if ($model->hasPasswordConfirmation() && $model->getPasswordConfirmation() === '') {
                $model->unsPasswordConfirmation();
            }

            try {
                $model->save();
                // Assign Document Role For Document User - HungDQ
                $uRoles = array(Mage::helper('document')->getDocumentSupplierRoleId());
                $model->setRoleIds($uRoles)
                    ->setRoleUserId($model->getUserId())
                    ->saveRelations();

                if($data['tier_commission'] && $model->getId()){
                    foreach($data['tier_commission'] as $tierCommission){
                        $tierModel = Mage::getModel('document/tiercommission');
                        if($tierCommission['delete'] == ''){
                            $tierModel->saveTierCommission($tierCommission, $model->getId());
                        }else{
                            $tierModel->deleteTierCommission($tierCommission);
                        }
                    }
                }

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The document supplier user has been saved.'));

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
        if ($id = $this->getRequest()->getParam('id')) {
            try {
                $model = Mage::getModel('admin/user');
                $model->setId($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The document supplier user has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('user_id' => $this->getRequest()->getParam('user_id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find a document supplier user to delete.'));
        $this->_redirect('*/*/');
    }

    public function orderTabAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('document.edit.tab.order')
            ->setOrders($this->getRequest()->getPost('oorder', null));
        $this->renderLayout();
    }

    public function exportOrderHistoryPdfAction()
    {
        $documentId = $this->getRequest()->getParam('documentId');
        $documentSupplier = Mage::getModel('admin/user')->load($documentId);
        try {
            $pdf = Mage::getModel('document/pdf_supplier')->getPdf(array($documentSupplier));
            $name = Mage::helper('document')->__('Documentation Supplier') . '.pdf';
            $this->_prepareDownloadResponseV2($name, $pdf->render(), 'application/pdf');
        } catch (Exception $ex) {
            Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
            $this->_redirect('document/adminhtml_supplier/index');
        }
    }

    /**
     * Custom download response method for magento multi version compatibility
     */
    protected function _prepareDownloadResponseV2($fileName, $content, $contentType = 'application/octet-stream') {
        $this->getResponse()
                ->setHttpResponseCode(200)
                ->setHeader('Pragma', 'public', true)
                ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
                ->setHeader('Content-type', $contentType, true)
                ->setHeader('Content-Length', strlen($content))
                ->setHeader('Content-Disposition', 'attachment; filename=' . $fileName)
                ->setBody($content);
    }

    /*
    * #119 - HungDQ - Send Order History Email function
    */
    public function sendOrderHistoryEmailAction()
    {
        $documentId = $this->getRequest()->getParam('documentId');
        $documentSupplier = Mage::getModel('admin/user')->load($documentId);
        try {
            // Generate order history pdf file
            $pdf = Mage::getModel('document/pdf_supplier')->getPdf(array($documentSupplier));

            $emailTemplate = Mage::getModel('core/email_template');
            $mailer = Mage::getModel('core/email_template_mailer');
            if ($pdf) {
                $mailer->addAttachment($emailTemplate, $pdf, 'order_history.pdf');
            }
            $emailTemplate->sendTransactional(
                Mage::getStoreConfig('document/supplier/order_history_template'),
                Mage::getStoreConfig('sales_email/order/identity', 0),
                $documentSupplier->getEmail(),
                $documentSupplier->getUsername(),
                array()
            );
            $this->_getSession()->addSuccess($this->__('Order history email has been successfully sent'));
        } catch (Exception $ex) {
            $this->_getSession()->addError($ex->getMessage());
        }
        $this->_redirect('*/*/index');
    }
}