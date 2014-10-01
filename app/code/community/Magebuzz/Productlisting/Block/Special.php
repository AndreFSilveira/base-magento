<?php
class Magebuzz_Productlisting_Block_Special extends Mage_Catalog_Block_Product_Abstract
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
    public function getProductlisting()     
     {	 
        if (!$this->hasData('productlisting')) {
            $this->setData('productlisting', Mage::registry('productlisting'));
        }		
        return $this->getData('productlisting');
    }
	
	public function __construct() {
		$this->setProductCollection($this->getSpecialProducts());
		return $this;
	}
	
	public function getSpecialProducts() {
		$current_category = Mage::registry('current_category');
		$is_category_filter = Mage::getStoreConfig('productlisting/product_setting/category_filter');
		$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
		$collection = Mage::getResourceModel('catalog/product_collection')
								->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
								->addAttributeToFilter('special_from_date', array('or'=> array(
									0 => array('date' => true, 'to' => $todayDate),
									1 => array('is' => new Zend_Db_Expr('null')))
								), 'left')
								->addAttributeToFilter('special_to_date', array('or'=> array(
									0 => array('date' => true, 'from' => $todayDate),
									1 => array('is' => new Zend_Db_Expr('null')))
								), 'left')
								->addAttributeToFilter(
									array(
										array('attribute' => 'special_from_date', 'is'=>new Zend_Db_Expr('not null')),
										array('attribute' => 'special_to_date', 'is'=>new Zend_Db_Expr('not null'))
										)
								  )
								->addAttributeToSort('special_to_date','desc')
								->addTaxPercents()
								->addStoreFilter();	
			Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
			Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);	
		if($current_category && $is_category_filter == '1'){
			$current_category_id = Mage::registry('current_category')->getId();
			$currentCategory = Mage::getModel('catalog/category')->load($current_category_id);
			$collection->addCategoryFilter($currentCategory);
		}
		return $collection;	
	}
	public function getPageTitle(){
		return 'Special Products';
	}
	
	public function showDescription(){
		return (int)Mage::getStoreConfig('productlisting/product_setting/show_description');
	}
}