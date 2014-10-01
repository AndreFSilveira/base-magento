<?php
class Magebuzz_Productlisting_Block_Bestseller extends Mage_Catalog_Block_Product_Abstract
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
		$this->setProductCollection($this->getBestsellerProducts());
		return $this;
	}
	
	public function getBestsellerProducts(){
		$current_category = Mage::registry('current_category');
		$is_category_filter = Mage::getStoreConfig('productlisting/product_setting/category_filter');
		$collection = Mage::getResourceModel('reports/product_collection')
							->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
							->addOrderedQty()
							->addMinimalPrice()
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
		return 'Best Selling Products';
	}
	
	public function showDescription(){
		return (int)Mage::getStoreConfig('productlisting/product_setting/show_description');
	}
}