<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_NavigationMenuPro_Adminhtml_MenucreatorController extends Mage_Adminhtml_Controller_Action
{
	
	protected function _initAction() {
	
		$this->loadLayout()
			->_setActiveMenu('cws')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
	 	return $this;	
		
	}   
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	public function manageitemAction() {
		$this->_initAction()
			->renderLayout();
	}
	public function testpopupAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('navigationmenupro/menucreator')->load($id);
		
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			
			if (!empty($data)) {
				
				$model->setData($data);
				
			}

			Mage::register('menucreator_data', $model);
			
			$this->loadLayout();
			$this->_setActiveMenu('cws');
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreator_edit'))
				->_addLeft($this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreator_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('navigationmenupro')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	public function editformAction()
	{
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('navigationmenupro/menucreator')->load($id);
		$this->getResponse()->setBody(json_encode($model->getData()));
	}
	
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
	
		if ($data = $this->getRequest()->getPost()) {
		
		$model = Mage::getModel('navigationmenupro/menucreator');
		
		if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
                try
                {
                    $path = Mage::getBaseDir().DS.'media/navigationmenupro/image'.DS;
                    
					$ext=substr(strchr($_FILES['image']['name'],'.'),1);
					$randname=md5(rand()*time());
					$fname=$randname.'.'.$ext;
                    $uploader = new Varien_File_Uploader('image');
                    $uploader->setAllowedExtensions(array('jpg','jpeg','png','gif'));
                    $uploader->setAllowCreateFolders(true);
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    $destFile = $path.$fname;
                    $fname  = $model->getNewFileName($destFile);
                    $uploader->save($path,$fname);
                }
                catch (Exception $e)
                {	
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('navigationmenupro')->__($e->getMessage()));
                    $this->_redirect('*/*/manageitem');
					return;
                }
				
		        //this way the name is saved in DB
	  			//$data['image'] = $_FILES['image']['name'];
				// Change the Random file name 
				$data['image'] = $fname;
			}else{
                unset($data['image']);
            }
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			if(isset($data['menu_id']))
			{
			if ($data['menu_id'] != "") {
            	$model->setData($data)->setId($data['menu_id']);
				}
			}
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				 if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ''){	
				$model->setImage($fname);
				}
			
			$storeids="";
			if(isset($data['storeids']))
			{
			if(in_array("0", $data['storeids']))
			{
			$defaultstore_id="0".",";
							$storeids = '';
							$allStores = Mage::app()->getStores();
							/* Get All Store Id in the storeids*/
							foreach ($allStores as $_eachStoreId => $val) 
							{
								$_storeId = Mage::app()->getStore($_eachStoreId)->getId();
								$storeids.=$_storeId.",";
							}
							/* Add O as store Id for all the store
							*/
							$storeids = $defaultstore_id.$storeids;
							$model->setStoreids($storeids);
							$storeids="";
			}else
			{
			$storeids="";
			foreach($data['storeids'] as $store):
			$storeids.=$store.",";
			endforeach;
			$model->setStoreids($storeids);
							$storeids="";
			}
			
			}
			if(isset($data['setrel']))
			{
			$setrel="";
			foreach($data['setrel'] as $relation):
			$setrel.=$relation." ";
			endforeach;
			$model->setSetrel($setrel);
			$setrel="";
			}else
			{
			$setrel="";
			$model->setSetrel($setrel);
			}
		
			if(isset($data['remove_img_main']))
			{
			if($data['remove_img_main']=="1")
			{
			$id = $this->getRequest()->getParam('id');
			/* When AJAX Request Pass then it will use below code for the Id.*/
			if($id == "")
			{
			$id = $data['menu_id'];
			}
			$model_image_remove  = Mage::getModel('navigationmenupro/menucreator')->load($id);
			$image_name = $model_image_remove->getImage();
			$path = Mage::getBaseDir().DS.'media\navigationmenupro\image'.DS.$image_name;
				if(file_exists($path)){
						unlink($path);
				}
			$model_image_remove->setImage("");
			$model_image_remove->save();
			}
			}
			if(isset($data['title_show_hide'])){
					$model->setTitle_Show_Hide($data['title_show_hide']);
			}
			if(isset($data['autosub'])){
					$model->setAutosub($data['autosub']);
				}else{
					$model->setAutosub(0);
				}
				
				if(isset($data['use_category_title'])){
					$model->setUseCategoryTitle($data['use_category_title']);
				}else{
					$model->setUseCategoryTitle(0);
				}
				if(isset($data['autosubimage'])){
					$model->setAutosubimage($data['autosubimage']);
				}else{
					$model->setAutosubimage(0);
				}
				if(isset($data['image_type']))
				{
				$model->setShowCategoryImage($data['image_type']);
				/*show_category_image*/
				}
				if(isset($data['useexternalurl'])){
					$model->setUseexternalurl($data['useexternalurl']);
				}else{
					$model->setUseexternalurl(0);
				}
				if($data['type']=="2"){
					if(isset($data['show_custom_category_image']))
					{
					$model->setShowCustomCategoryImage($data['show_custom_category_image']);
					}
					else
					{
					$model->setImage("");
					$model->setShowCustomCategoryImage("0");
					}
				}
				$model->setLabelTitle($data['label_title']);
				$model->setLabelHeight($data['height']);
				$model->setLabelColor($data['label_text_color']);
				$model->setLabelBgColor($data['label_text_bg_color']);
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('navigationmenupro')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/manageitem');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                
				$this->_redirect('*/*/manageitem');
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('navigationmenupro')->__('Unable to find item to save'));
		$this->_redirect('*/*/manageitem');
        
	}
	public function deleteitemsAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
				$model = Mage::getModel('navigationmenupro/menucreator');
				 $currentmenu_id = $this->getRequest()->getParam('id');
				 $menu_delete_option = $this->getRequest()->getParam('deleteoption');
				 $child_menu_item_list = array();
				 $child_menu_item = $model->getChildMenuItem($currentmenu_id);
				 $child_menu_item_list[$currentmenu_id] = $child_menu_item;
			
				 $delete_menu = array();
				 foreach($child_menu_item as $key => $menuitem)
				 {	
					if(!is_array($menuitem))
					{
					array_push($delete_menu,$menuitem);
					}
				 
				 }
				 
				if($menu_delete_option == "deleteparent")
				 {
					try {
						foreach($delete_menu as $menuid)
						{
						if($currentmenu_id == $menuid)
						{
						$model = Mage::getModel('navigationmenupro/menucreator');
						$model->setId($menuid)->delete();
						}else
						{
						$model = Mage::getModel("navigationmenupro/menucreator")->load($menuid);
							if($model->getParentId() == $currentmenu_id)
							{
							$model->setParentId("0");
							$model->setPosition("0");
							}
						
						$model->save();
						}
						}
						$this->_getSession()->addSuccess(
							$this->__('Item was successfully deleted')
						);
					} catch (Exception $e) {
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*/manageitem');
				}
				
				 }else if($menu_delete_option== "deleteparentchild")
				 {
				
				 try{
				 $i=0;
				 foreach($delete_menu as $menuid)
				 {		$i++;
						$menuitem = Mage::getModel('navigationmenupro/menucreator')->load($menuid);
						$menuitem->delete();
						
				}
					$this->_getSession()->addSuccess(
                    $this->__('Total of %d menu item(s) were successfully deleted', count($delete_menu)));
				} catch (Exception $e) {
						Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
						$this->_redirect('*/*/manageitem');
					}
				}
		}
	}
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('navigationmenupro/menucreator');
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $menucreatorIds = $this->getRequest()->getParam('navigationmenupro');
        if(!is_array($menucreatorIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($menucreatorIds as $menucreatorId) {
                    $menuitem = Mage::getModel('navigationmenupro/menucreator')->load($menucreatorId);
                    $menuitem->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($menucreatorIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $menucreatorIds = $this->getRequest()->getParam('navigationmenupro');
        if(!is_array($menucreatorIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($menucreatorIds as $menucreatorId) {
                    $member = Mage::getSingleton('navigationmenupro/menucreator')
                        ->load($menucreatorId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($menucreatorIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	public function exportCsvAction()
    {
	
        
            //write headers to the csv file
			$menucreator = Mage::getSingleton('navigationmenupro/menucreator')->getCollection();
			$content = "";
			
            try {
                
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
                $this->_redirect('*/*/index');
            }
            $this->_prepareDownloadResponse('menucreator.csv', $content, 'text/csv');
       

    }
	
	public function updateMenuAction()
	{
	
	$menu_order_item_details = array();
	$all_menuitems = $_POST['menuitemorder'];
	
	if($all_menuitems != '')
	{
	$menus=explode("&", $all_menuitems);
	
		foreach($menus as $item_key => $item_value)
		{
		if(!empty($item_value))
		{
		$menu_item_order = explode("=", $item_value);
		if (strpos($menu_item_order[0],'group[id]') !== false) {
		$group_id = $menu_item_order[1];
		}
		if (strpos($menu_item_order[0],'menuItem') !== false) {
		$menu_id = str_replace("menuItem[","",$menu_item_order[0]);
		$menu_id = str_replace("]","",$menu_id);
		if($menu_item_order[1] == 'null')
		{
		$parent_id = '0';
		}else
		{
		$parent_id = $menu_item_order[1];
		}
		$menu_order_item_details[$menu_id] =  array(
												'group_id' => $group_id,
												'parent_id' => $parent_id
		);;
		}
		}
		}
			$temp=array();
			$finalsort=array();
			foreach($menu_order_item_details as $key => $value)
			{		
				if($key != '')
				{
					$temp[$key]=$value['parent_id'];
					$finalsort[$key]=array('group_id' => $value['group_id'],'parent'=>$value['parent_id'],'sortorder'=> $this->get_Sortorder($value['parent_id'],$temp));
				}
			}
			
			try {
			
			foreach($finalsort as $menu_id => $values):
			if($menu_id != "0"){
					$model=Mage::getModel("navigationmenupro/menucreator")->load($menu_id);
					$model->setGroupId($values['group_id']);
					$model->setParentId($values['parent']);
					$model->setPosition($values['sortorder']);
					$model->save();
			}
					
			endforeach;
			
			$this->_getSession()->addSuccess($this->__('Menu Items Order Changes Save Successfully'));
			}
             catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
			$all_menuitems = '';
	}		
	}
	public function get_Sortorder($match, $temp)
			{
				$count = 0;
			   
				foreach ($temp as $key => $value)
				{
					if ($value == $match)
					{
						$count++;
					}
				}
			   
				return $count;
			}
	public function _isAllowed()
		{
			return true;
		}
	
	}