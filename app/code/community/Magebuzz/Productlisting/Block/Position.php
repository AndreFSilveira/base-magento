<?php
class Magebuzz_Productlisting_Block_Position extends Magebuzz_Productlisting_Block_Productlisting
{
	public function _prepareLayout()
    {
		$is_homepage = false;
		$slider_position = 'only_home';//Mage::getStoreConfig('productlisting/slider_setting/slider_position');
		$current_category = Mage::registry('current_category');
		$in_category = $this->inCategoryPage();
		if($this->getUrl('') == $this->getUrl('*/*/*', array('_use_rewrite'=>true)))
		{
			$is_homepage = true;
		}
		parent::_prepareLayout();
		if (!$this->getTemplate() && $slider_position == 'only_home' && $is_homepage == true) {
            $this->setTemplate('productlisting/productlisting.phtml');
        }
		if (!$this->getTemplate() && $slider_position == 'only_category_page' && $in_category == 'catalog_category_view') {
            $this->setTemplate('productlisting/productlisting.phtml');
        }
		if (!$this->getTemplate() && $slider_position == 'both_home_category') {
			if($in_category == 'catalog_category_view' || $is_homepage == true){
				$this->setTemplate('productlisting/productlisting.phtml');
			}
        }
		
		//$this->setTemplate('productlisting/productlisting.phtml');
		
        return $this;
    }
}