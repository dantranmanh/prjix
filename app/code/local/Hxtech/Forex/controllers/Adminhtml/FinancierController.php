<?php

class Hxtech_Forex_Adminhtml_FinancierController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->loadLayout()->renderLayout();
    }

    protected function _isAllowed(){
        return Mage::getSingleton('admin/session')->isAllowed('forex/financier');
    }

    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('forex/financier');

        if ($id) {
            $model->load($id);
            $data = Mage::getSingleton('adminhtml/session')->getFormData(TRUE);
            if (!empty($data)) {
                $model->setData($data);
            }
        }
        Mage::register('financier_data', $model);
        $this->loadLayout();

        $this->getLayout()->getBlock('head')->setCanLoadExtJs(TRUE);

        $this->_addContent($this->getLayout()->createBlock('forex/adminhtml_financier_edit'))->_addLeft($this->getLayout()->createBlock('forex/adminhtml_financier_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_redirect('*/*/edit');
    }

    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
            if(isset($data['exclude_countries'])){
                $data['exclude_countries'] = implode(",", $data['exclude_countries']);
            }
            $id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('forex/financier')->load($id);
            if (isset($_FILES['logo']['name']) && $_FILES['logo']['name'] != '') {
                try {
                    //rename image in case image name has space
                    $image_name = $_FILES['logo']['name'];
                    $new_image_name = Mage::helper('logistic')->renameImage($image_name);

                    $uploader = new Varien_File_Uploader('logo');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(TRUE);
                    $uploader->setFilesDispersion(FALSE);

                    $path = Mage::getBaseDir('media') . DS . 'forex' . DS . 'financier' .DS. 'logo';
                    if (!is_dir($path)) {
                        mkdir($path, 0777, TRUE);
                    }

                    if (!file_exists($path . DS . $new_image_name)) {
                        $uploader->save($path, $new_image_name);
                    }
                } catch (Exception $e) {
                    Mage::getSingleton('admin/session')->addError($e->getMessage());
                }
                $data['logo'] = $new_image_name;
            }
            if (isset($data['logo']['delete']) && $data['logo']['delete'] == 1) {
                $data['logo'] = '';
            }  elseif ($model->getLogo()) {
                $data['logo'] = $model->getLogo();
            }

            $model->addData($data);

            try {
                $model->save();

                if(isset($data['tier_commission']) && $model->getId()){
                    foreach($data['tier_commission'] as $tierCommission){
                        $tierModel = Mage::getModel('forex/tiercommission');
                        if($tierCommission['delete'] == ''){
                            $tierModel->saveTierCommission($tierCommission, $model->getId());
                        }else{
                            $tierModel->deleteTierCommission($tierCommission);
                        }
                    }
                }

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The financer information has been saved successfully.'));

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
                $model = Mage::getModel('forex/financier');
                $model->setId($id);
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The financier has been deleted successfully.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find a financier to delete.'));
        $this->_redirect('*/*/');
    }
}