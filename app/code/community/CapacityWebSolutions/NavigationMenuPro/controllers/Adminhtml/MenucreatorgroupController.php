<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
 class CapacityWebSolutions_NavigationMenuPro_Adminhtml_MenucreatorgroupController extends Mage_Adminhtml_Controller_Action
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
	
	public function editAction() {
		
		//$this->_initAction();
		
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('navigationmenupro/menucreatorgroup')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('menucreatorgroup_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('cws');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreatorgroup_edit'))
				->_addLeft($this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreatorgroup_edit_tabs'));
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('navigationmenupro')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
		
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			$model = Mage::getModel('navigationmenupro/menucreatorgroup');	
			
			if(!isset($data['root']['lvl0dvcolor'])){
			$data['root']['lvl0dvcolor']='';	
			}
			/* Set Default value for the Responsive break point */
			if($data['mobilemenu']['responsive_breakpoint']==""){
				$data['mobilemenu']['responsive_breakpoint']='767px';	
			}
			if(!isset($data['mobilemenu']['mmlvl0dvcolor'])){
			$data['mobilemenu']['mmlvl0dvcolor']='';	
			}
			if(!isset($data['sub']['sublvl1dvcolor'])){
			$data['sub']['sublvl1dvcolor']='';	
			}
			if(!isset($data['mega']['mmlvl1dvcolor'])){
			$data['mega']['mmlvl1dvcolor']='';	
			}
			if(!isset($data['mega']['mmlvl2dvcolor'])){
			$data['mega']['mmlvl2dvcolor']='';	
			}
			if(!isset($data['mega']['mmlvl3dvcolor'])){
			$data['mega']['mmlvl3dvcolor']='';	
			}
			if(!isset($data['fly']['ddlinkdvcolor'])){
			$data['fly']['ddlinkdvcolor']='';	
			}
			$data['rootoptions'] = json_encode($data['root']);
			$data['mobilemenuoptions'] = json_encode($data['mobilemenu']);
			$data['megaoptions'] = json_encode($data['mega']);
			$data['suboptions'] = json_encode($data['sub']);
			$data['flyoptions'] = json_encode($data['fly']);
		
			
			
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				/*$model->setPosition("2");
				*/
				$model->setDescription("This is descriptions");
				if(isset($data['alignment']))
				{
				$model->setAlignment($data['alignment']);
				}
				$model->setMobilemenuoptions($data['mobilemenuoptions']);
				
				$model->save();
				/*Start Working to  Create & Update the Dynamic Css file for the menu items*/
				if($this->getRequest()->getParam('id') == "")
				{
				$group_id = $model->getData('group_id');
				}else
				{
				$group_id = $this->getRequest()->getParam('id');
				}
				
				$current_theme = Mage::getSingleton('core/design_package')->getTheme('frontend');
				
				require_once(Mage::getBaseDir('lib') . DS .'navigationmenupro'. DS .'lessphp'.DS.'Less.php');
				
				if (!file_exists(Mage::getBaseDir('skin').DS.'frontend'.DS.'base'.DS.'default'.DS.'css'.DS.'navigationmenupro'))
				{
					mkdir(Mage::getBaseDir('skin').DS.'frontend'.DS.'base'.DS.'default'.DS.'css'.DS.'navigationmenupro', 0777, true);
				}
				$cssDir = Mage::getBaseDir('skin').DS.'frontend'.DS.'base'.DS.'default'.DS.'css'.DS.'navigationmenupro'.DS;
				
				$path_less = $cssDir;
				$path_css = $cssDir;
				$menu_type = $model->getMenutype();
				/*if($menu_type!=""){
						echo $menu_type = $model->getMenutype();die;
				}*/
					if($menu_type!=""){
						
						$css_less = $this->get_less_variable($group_id);
						$menu_type = $model->getMenutype();
						//$menu_type = $model->getMenutype();
						//$oldfile = "-".$group_id.".less";
						$files1 = scandir($path_less);
						$list_lessfiles =  $cssDir.'/*.less';
						$file_name_check = "-".$group_id.".less";
						foreach (glob($list_lessfiles) as $filename){
							if($this->endsWith($filename, $file_name_check)){
								if(is_file($filename)) {
								$result = unlink($filename); // delete Old Less file
								}
							}
						}
						$list_cssfiles =  $cssDir.'/*.css';
						$file_name_check = "-".$group_id.".css";
						foreach (glob($list_cssfiles) as $filename){
							if($this->endsWith($filename, $file_name_check)){
								if(is_file($filename)) {
								$result = unlink($filename); // delete Old Css file
								}
							}
						}
						$test_css = $cssDir;
						$test_less = $menu_type."-".$group_id.".less";
						$test_css .= 'test'.$menu_type."-".$group_id.".css";
						$path_less .= $menu_type."-".$group_id.".less";
						$path_css .= $menu_type."-".$group_id.".css";
						
								
								
								
						if($menu_type=="mega-menu")
						{
								$master_less_file = $cssDir.'/'.'master-mega-menu.php';
								$master_less = file_get_contents($master_less_file);
								$content = $css_less.$master_less;
								file_put_contents($path_less,$content);
								
								try {
								$parser = new Less_Parser();
								$parser->parseFile($path_less, Mage::getBaseUrl());
								 $css = $parser->getCss();
								file_put_contents($path_css,$css);
								} catch (exception $e) {
									
								Mage::getSingleton('adminhtml/session')->addError(Mage::helper('navigationmenupro')->__($e->getMessage()));
								$this->_redirect('*/*/');
								}
								
								

								
						}elseif(($menu_type=="smart-expand")||($menu_type=="always-expand")){
								$master_less_file = $cssDir.'/'.'master-expand-menu.php';
								$master_less = file_get_contents($master_less_file);
								$content = $css_less.$master_less;
								file_put_contents($path_less,$content);
								
								try {
								$parser = new Less_Parser();
								$parser->parseFile($path_less, Mage::getBaseUrl());
								$css = $parser->getCss();
								file_put_contents($path_css,$css);
								} catch (exception $e) {
								Mage::getSingleton('adminhtml/session')->addError(Mage::helper('navigationmenupro')->__($e->getMessage()));
								$this->_redirect('*/*/');
								}
						}
					}
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('navigationmenupro')->__('Menu Group Information was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('navigationmenupro')->__($e->getMessage()));
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/');
                return;
            }
        }
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('navigationmenupro')->__('Unable to find menu group information to save'));
        
        $this->_redirect('*/*/');
		
	}
	
	public function deleteAction() {
		
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$menucreatorgroupId = $this->getRequest()->getParam('id');
				//$group_id = $menucreatorgroupId;
				//$model = Mage::getModel('navigationmenupro/menucreatorgroup');
				$menucreatorgroup = Mage::getModel('navigationmenupro/menucreatorgroup')->load($menucreatorgroupId);
					
					/* Delete the css file from the directory*/
					$menu_type = $menucreatorgroup->getMenutype();
					$cssDir = Mage::getBaseDir('skin').DS.'frontend'.DS.'base'.DS.'default'.DS.'css'.DS.'navigationmenupro'.DS;
					$path_less = $cssDir;
					$path_css = $cssDir;
					$path_less .= $menu_type."-".$menucreatorgroupId.".less";
					$path_css .= $menu_type."-".$menucreatorgroupId.".css";
					if($menu_type=="mega-menu")
					{
						if(is_file($path_less))
						{
						unlink($path_less);
						}
						if(is_file($path_css))
						{
						unlink($path_css);
						}
								
					}elseif(($menu_type=="smart-expand")||($menu_type=="always-expand")){
						if(is_file($path_less))
						{
						unlink($path_less);
						}
						if(is_file($path_css))
						{
						unlink($path_css);
						}		
					}
					/* Delete Css File Code Complete*/
                    $menucreatorgroup->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Menu group was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $menucreatorgroupIds = $this->getRequest()->getParam('navigationmenupro');
     
		if(!is_array($menucreatorgroupIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Menu group(s)'));
        } else {
            try {
			/* Delete the css file from the directory*/
				foreach ($menucreatorgroupIds as $menucreatorgroupId) {
                    $menucreatorgroup = Mage::getModel('navigationmenupro/menucreatorgroup')->load($menucreatorgroupId);
					
					$menu_type = $menucreatorgroup->getMenutype();
					$cssDir = Mage::getBaseDir('skin').DS.'frontend'.DS.'base'.DS.'default'.DS.'css'.DS.'navigationmenupro'.DS;
					$path_less = $cssDir;
					$path_css = $cssDir;
					$path_less .= $menu_type."-".$menucreatorgroupId.".less";
					$path_css .= $menu_type."-".$menucreatorgroupId.".css";
					if($menu_type=="mega-menu")
					{
						if(is_file($path_less))
						{
						unlink($path_less);
						}
						if(is_file($path_css))
						{
						unlink($path_css);
						}
								
					}elseif(($menu_type=="smart-expand")||($menu_type=="always-expand")){
						if(is_file($path_less))
						{
						unlink($path_less);
						}
						if(is_file($path_css))
						{
						unlink($path_css);
						}		
					}
                    $menucreatorgroup->delete();
				/* Delete Css File Code Complete*/
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($menucreatorgroupIds)
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
		$delivered_status = (int) $this->getRequest()->getPost('status');
		$menucreatorgroupIds = $this->getRequest()->getParam('navigationmenupro');
        if(!is_array($menucreatorgroupIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Menu group(s)'));
        } else {
            try {
                foreach ($menucreatorgroupIds as $menucreatorgroupId) {
                    $menucreatorgroup = Mage::getSingleton('navigationmenupro/menucreatorgroup')
                        ->load($menucreatorgroupId)
                        ->setStatus($delivered_status)
                        ->save();
                }
				
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d group(s) status were successfully updated', count($menucreatorgroupIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	public function massLevelAction()
    {
		$delivered_level = (int)$this->getRequest()->getPost('level')-1;
		$menucreatorgroupIds = $this->getRequest()->getParam('navigationmenupro');
        if(!is_array($menucreatorgroupIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Menu group(s)'));
        } else {
            try {
                foreach ($menucreatorgroupIds as $menucreatorgroupId) {
                    $menucreatorgroup = Mage::getSingleton('navigationmenupro/menucreatorgroup')
                        ->load($menucreatorgroupId)
                        ->setLevel($delivered_level)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d groups(s) menu level were successfully updated', count($menucreatorgroupIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
	public function get_menu_css($group_id)
	{
	$groupdata = Mage::getModel("navigationmenupro/menucreatorgroup")->load($group_id);
	$alignment = $groupdata->getPosition();
	$menutype = $groupdata->getMenutype();
	$grouptitletextcolor = $groupdata->getTitletextcolor();
	$grouptitlebgcolor = $groupdata->getTitlebackcolor();
	$itemimageheight = $groupdata->getImageHeight();
	$itemimagewidth = $groupdata->getImageWidth();
	
	$textcolor = $groupdata->getItemtextcolor();
	$texthovercolor = $groupdata->getItemtexthovercolor();
	$textactivecolor = $groupdata->getrootactivecolor();
	$itembgcolor = $groupdata->getItembgcolor();
	$itembghovercolor = $groupdata->getItembghovercolor();
	$arrowcolor = $groupdata->getArrowcolor();
	$dividercolor = $groupdata->getDividercolor();
	$menu_bg_color = $groupdata->getMenubgcolor();
	$drop_bg_color = $groupdata->getSubitemsbgcolor();
	$drop_border_color = $groupdata->getSubitemsbordercolor();
	$megaparenttextcolor = $groupdata->getMegaparenttextcolor();
	$megaparenttexthovercolor = $groupdata->getMegaparenttexthovercolor();
	$megaparenttextactivecolor = $groupdata->getMegaparenttextactivecolor();
	$megaparenttextbgcolor = $groupdata->getMegaparenttextbgcolor();
	$megaparenttextbghovercolor = $groupdata->getMegaparenttextbghovercolor();
	$subitemtextcolor = $groupdata->getSubitemtextcolor();
	$subitemtexthovercolor = $groupdata->getSubitemtexthovercolor();
	$itemactivecolor = $groupdata->getItemactivecolor();
	$subitembgcolor = $groupdata->getSubitembgcolor();
	$subitembghovercolor = $groupdata->getSubitembghovercolor();
	$subarrowcolor = $groupdata->getSubarrowcolor();
	$subdividercolor = $groupdata->getSubitemdividercolor();
	
	
	$css = '';
	// Common class
	$css .= '#cwsMenu-'.$group_id.' { background-color:#'.$menu_bg_color.'; }';
	$css .= '#cwsMenu-'.$group_id.' .menuTitle { color:#'.$grouptitletextcolor.'; background-color:#'.$grouptitlebgcolor.'; }';
	$css .= '#cwsMenu-'.$group_id.' ul.cwsMenu span.img { max-height:'.$itemimageheight.'px; max-width:'.$itemimagewidth.'px; }';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.horizontal > li.parent > a:after { border-top-color:#'.$arrowcolor.'; }'; // Horizontal
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.vertical > li.parent > a:after { border-left-color:#'.$arrowcolor.'; }'; // Verticle
	
	// First lavel
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.Level0 > a { color:#'.$textcolor.'; background-color:#'.$itembgcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu.mega-menu li.Level0:hover > a { color:#'.$texthovercolor.'; background-color:#'.$itembghovercolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu.smart-expand li.Level0 > a:hover,';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu.always-expand li.Level0 > a:hover { color:#'.$texthovercolor.'; background-color:#'.$itembghovercolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.Level0.active > a { color:#'.$textactivecolor.'; }';

	$css .='#cwsMenu-'.$group_id.' .cwsMenu.horizontal > li.parent > a:after { border-top-color:#'.$arrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.horizontal > li { border-right-color:#'.$dividercolor.'; }';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.vertical > li { border-top-color:#'.$dividercolor.'; }';
	
	#cwsMenu-1 ul.cwsMenu li.hideTitle li a.Level2 { color:#83b925; font-weight:bold; font-size: 12px; }*/
	
	// Second lavel
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li > ul.subMenu { background-color:#'.$drop_bg_color.'; border-color:#'.$drop_border_color.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li li > a { color:#'.$subitemtextcolor.'; background-color:#'.$subitembgcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu.mega-menu li li:hover > a { color:#'.$subitemtexthovercolor.'; background-color:#'.$subitembghovercolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li li.active > a { color:#'.$itemactivecolor.'; }';

	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu.mega-menu li.column-1 li.parent > a:after { border-left-color:#'.$subarrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.'.rtl ul.cwsMenu.mega-menu li.column-1 li.parent > a:after { border-right-color:#'.$subarrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.'.rtl .cwsMenu.vertical > li.parent.aRight > a:after { border-right-color:#'.$subarrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.'.rtl .cwsMenu.vertical li.column-1.aRight li.parent > a:after { border-right-color:#'.$subarrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li ul > li { border-bottom-color:#'.$subdividercolor.'; }';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.vertical > li li { border-top-color:#'.$subdividercolor.'; }';
	
	// Megamenu column title Color
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.megamenu ul li.Level1 > a { color:#'.$megaparenttextcolor.'; background-color:#'.$megaparenttextbgcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.megamenu ul li.Level1:hover > a { color:#'.$megaparenttexthovercolor.'; background-color:#'.$megaparenttextbghovercolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.megamenu li.Level1 ul.Level1 > li { border-bottom-color:#'.$subdividercolor.'; }';
	
	// Megamenu column When hide title of column
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.megamenu ul li.hideTitle li.Level2 > a { color:#'.$megaparenttextcolor.'; background-color:#'.$megaparenttextbgcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.megamenu ul li.hideTitle li.Level2:hover > a { color:#'.$megaparenttexthovercolor.'; background-color:#'.$megaparenttextbghovercolor.'; }';
	
	// Smart/Always Expand Color
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.smart-expand li > span.arw { color:#'.$arrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.smart-expand > li,';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.always-expand > li { border-top-color:#'.$dividercolor.'; }';
	
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.smart-expand li li > span.arw { color:#'.$subarrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.smart-expand > li li,';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.always-expand > li li { border-top-color:#'.$subdividercolor.'; }';
	
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu.always-expand li li a:hover { color:#'.$subitemtexthovercolor.'; background-color:#'.$subitembghovercolor.'; }';
	
	
	return $css;
	}
	public function get_less_variable($group_id)
	{
		$groupdata = Mage::getModel("navigationmenupro/menucreatorgroup")->load($group_id);
		
		/*
		responsive_break_point
		*/
		/*$responsive_breakpoint = '';
		$responsive_breakpoint = Mage::helper("navigationmenupro")->getBreakPoint();
		*/
		$dynamic_variable = '';
		$dynamic_variable = '@group_id:'.$group_id.';'.PHP_EOL;
		$itemimageheight = $groupdata->getImageHeight().'px';
		$dynamic_variable .= '@itemimageheight:'.$itemimageheight.';'.PHP_EOL;
		$itemimagewidth = $groupdata->getImageWidth().'px';
		$dynamic_variable .= '@itemimagewidth:'.$itemimagewidth.';'.PHP_EOL;
		
		/*if($responsive_breakpoint!="")
		{
		$dynamic_variable .= '@responsive_breakpoint:'.$responsive_breakpoint.';'.PHP_EOL;	
		}else{
			$dynamic_variable .= '@responsive_breakpoint:767px;'.PHP_EOL;
		}*/
		$informations = $groupdata->getData();
		
			foreach($informations as $key => $value):
					if($this->isJSON($value)){
					$sub_information = json_decode($value, true);
					
					foreach($sub_information as $subkey => $subvalue):
						if($subvalue==""){
						//$dynamic_variable .= '@'.$subkey.':;'.PHP_EOL;	
						}else{
							$dynamic_variable .= '@'.$subkey.':'.$subvalue.';'.PHP_EOL;
						}
					endforeach;
			}
			endforeach;
		return $dynamic_variable;
		
		
		
	}
	public function isJSON($string){
		return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
	}
	function endsWith($haystack, $needle)
	{
		$length = strlen($needle);
		if ($length == 0) {
			return true;
		}

		return (substr($haystack, -$length) === $needle);
	}
	public function _isAllowed()
	{
			return true;
	}
	
}