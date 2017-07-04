<?php

class Hxtech_Logistic_Model_Customer_Renderer_Closestport implements Varien_Data_Form_Element_Renderer_Interface
{
	public function render(Varien_Data_Form_Element_Abstract $element)
	{
		$collection = Mage::getModel('logistic/port')->getCollection();

		$form = $element->getForm();
		$closestPortValue = $form->getElement('closestport_name')->getValue();
		//Filter port collection by country id
   		$countryValue = $form->getElement('country_id')->getValue();
   		$collection = Mage::getModel('logistic/port')->getCollection();
   		$collection->addFieldToFilter('country_code', $countryValue);

		$htmlAttributes = $element->getHtmlAttributes();
    	foreach ($htmlAttributes as $key => $attribute) {
      		if ('type' === $attribute) {
	        	unset($htmlAttributes[$key]);
	        	break;
	      	}
   		}

		$html = '<tr>'."\n";
		/*$html .= '<td class="label"><label for="closestport_name">Closest Port</label></td>';
		$html .= '<td class="value">';
		$html .= '</td>';*/
		$elementClass = $element->getClass();
      	$html.= '<td class="label">'.$element->getLabelHtml().'</td>';
      	$html.= '<td class="value">';

     	$html .= '<select id="' . $element->getHtmlId() . '" name="' . $element->getName() . '" '
    	. $element->serialize($htmlAttributes) .'>' . "\n";
    	$html .= '<option value="">Please select an option</option>';
     	foreach ($collection as $item) {
	        $selected = ($closestPortValue == $item->getPort()) ? 'selected="selected"' : '';
	        $html.= '<option value="'.$item->getPort().'"'.$selected.'>'.$item->getPort().'</option>';
      	}
      	$html.= '</select>' . "\n";
     	$html.= '</td>';
     	$element->setClass($elementClass);
		return $html;
	}
}