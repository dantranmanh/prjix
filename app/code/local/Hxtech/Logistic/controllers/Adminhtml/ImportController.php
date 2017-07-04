<?php

class Hxtech_Logistic_Adminhtml_ImportController extends Mage_Adminhtml_Controller_Action
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

    public function saveAction()
    {
    	if($data = $this->getRequest()->getPost()){
    		if (isset($_FILES['csv_file']['name']) && $_FILES['csv_file']['name'] != '') {
    			try {
					$uploader = new Varien_File_Uploader('csv_file');
			        $uploader->setAllowedExtensions(array('csv'));
			        $uploader->setAllowRenameFiles(FALSE);
			        $uploader->setFilesDispersion(FALSE);
			        $path = Mage::getBaseDir('media') . DS . 'logistic' . DS . 'import' . DS;
			        $uploader->save($path, $_FILES['csv_file']['name']);
			        $new_file_name = $uploader->getUploadedFileName();
			        $filepath = $path . $new_file_name;
			        $handler = new Varien_File_Csv();
			        $importData = $handler->getData($filepath);
			        $countSuccess = 0;

			        foreach($importData as $key => $row){
			        	if($key == 0) continue;
			        	if($row[3] == "" || $row[4] == "") continue;
			        	$model = Mage::getModel('logistic/shippingrate');
			        	$model->setStatus($row[0]);
			        	$model->setNameOfService($row[1]);
			        	$model->setContainerSize($row[2]);
			        	$model->setShippingTerms($row[3]);
			        	$model->setTransportMethod($row[4]);
			        	$model->setOriginPort($row[5]);
			        	$model->setDestinationPort($row[6]);
			        	$model->setTransitTime($row[7]);
			        	$model->setPriceCbm($row[8]);
			        	$model->setDocumentationFee($row[9]);
			        	$model->setDestinationCountry($row[10]);
			        	try {
			        		$model->save();
			        		$countSuccess++;
			        		Mage::getSingleton('adminhtml/session')->addSuccess($countSuccess.' items have been successfully imported');
			        		$this->_redirect('*/*/');
			        	} catch (Exception $e) {
							Mage::logException($e->getMessage());
			        	}
			        }

    			} catch (Exception $e) {
    				Mage::logException($e->getMessage());
		        }
    		}
    	}
    }

    public function portAction()
    {
        $this->loadLayout()->renderLayout();
    }

    public function savePortAction()
    {
    	if($data = $this->getRequest()->getPost()){
    		if (isset($_FILES['csv_file']['name']) && $_FILES['csv_file']['name'] != '') {
    			try {
					$uploader = new Varien_File_Uploader('csv_file');
			        $uploader->setAllowedExtensions(array('csv'));
			        $uploader->setAllowRenameFiles(FALSE);
			        $uploader->setFilesDispersion(FALSE);
			        $path = Mage::getBaseDir('media') . DS . 'logistic' . DS . 'import' . DS . 'port' . DS;
			        $uploader->save($path, $_FILES['csv_file']['name']);
			        $new_file_name = $uploader->getUploadedFileName();
			        $filepath = $path . $new_file_name;
			        $handler = new Varien_File_Csv();
			        $importData = $handler->getData($filepath);
			        $countSuccess = 0;
			        foreach($importData as $key => $row){
			        	$model = Mage::getModel('logistic/port');
			        	if($row[0] != "" && $row[2] != ""){
			        		$model->setCountryCode($row[0]);
				        	$model->setPort($row[2]);
				        	try {
				        		$model->save();
				        		$countSuccess++;
				        		$this->_redirect('logistic/adminhtml_import/port');
				        	} catch (Exception $e) {
								Mage::logException($e->getMessage());
				        	}
			        	}
			        }
			        Mage::getSingleton('adminhtml/session')->addSuccess($countSuccess.' items have been successfully imported');
    			} catch (Exception $e) {
    				Mage::logException($e->getMessage());
		        }
    		}
    	}
    }
}