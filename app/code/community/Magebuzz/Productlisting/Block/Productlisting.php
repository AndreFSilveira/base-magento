<?php
class Magebuzz_Productlisting_Block_Productlisting extends Mage_Catalog_Block_Product_Abstract
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
		$productType = $this->getProductsType();	
		if(!$this->getProductCollection()){
			switch ($productType) {
				case 'random':
					$this->setProductCollection($this->getRandomProducts());
					break;
				case 'bestseller':
					$this->setProductCollection($this->getBestsellerProducts());
					break;
				case 'mostviewed':
					$this->setProductCollection($this->getMostviewedProducts());
					break;
				case 'recentlyadded':
					$this->setProductCollection($this->getRecentlyAdded());
					break;
				case 'special':
					$this->setProductCollection($this->getSpecialProducts());
					break;
				default:
					$this->setProductCollection($this->getRandomProducts());
					break;
			}
		}
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
		$_limit = $this->getNumProduct();
		$collection->setPageSize($_limit);
		return $collection; 
	}
	public function getMostviewedProducts(){
		$current_category = Mage::registry('current_category');
		$is_category_filter = Mage::getStoreConfig('productlisting/product_setting/category_filter');
		$collection = Mage::getResourceModel('reports/product_collection')
							->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
							->addViewsCount()
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
		$_limit = $this->getNumProduct();
		$collection->setPageSize($_limit);
		return $collection;
	}
	public function getRandomProducts() {
		$current_category = Mage::registry('current_category');
		$is_category_filter = Mage::getStoreConfig('productlisting/product_setting/category_filter');
		$collection = Mage::getResourceModel('catalog/product_collection')
							->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
							->addMinimalPrice()
							->addTaxPercents()
							->addStoreFilter();	
		Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
		Mage::getSingleton('catalog/product_visibility')->addVisibleInSearchFilterToCollection($collection);
		$collection->getSelect()->order('rand()');
		if($current_category && $is_category_filter == '1'){
			$current_category_id = Mage::registry('current_category')->getId();
			$currentCategory = Mage::getModel('catalog/category')->load($current_category_id);
			$collection->addCategoryFilter($currentCategory);
		}
		$_limit = $this->getNumProduct();
		$collection->setPageSize($_limit);
		return $collection;	
	}
	public function getRecentlyAdded() {
		$current_category = Mage::registry('current_category');
		$is_category_filter = Mage::getStoreConfig('productlisting/product_setting/category_filter');
		$todayDate  = Mage::app()->getLocale()->date()->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
		$collection = Mage::getResourceModel('catalog/product_collection')
							->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
							->addAttributeToSelect('*') //Need this so products show up correctly in product listing
							->addAttributeToFilter('news_from_date', array('or'=> array(
								0 => array('date' => true, 'to' => $todayDate),
								1 => array('is' => new Zend_Db_Expr('null')))
							), 'left')
							->addAttributeToFilter('news_to_date', array('or'=> array(
								0 => array('date' => true, 'from' => $todayDate),
								1 => array('is' => new Zend_Db_Expr('null')))
							), 'left')
							->addAttributeToFilter(
								array(
									array('attribute' => 'news_from_date', 'is'=>new Zend_Db_Expr('not null')),
									array('attribute' => 'news_to_date', 'is'=>new Zend_Db_Expr('not null'))
									)
							  )
							->addAttributeToSort('news_from_date', 'desc')
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
		$_limit = $this->getNumProduct();
		$collection->setPageSize($_limit);
		return $collection;	
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
		$_limit = $this->getNumProduct();
		$collection->setPageSize($_limit);
		return $collection;	
	}
	public function inCategoryPage($check='_')
    {
        return $this->getRequest()->getRequestedRouteName().$check.
            $this->getRequest()->getRequestedControllerName().$check.
            $this->getRequest()->getRequestedActionName();
    }
	public function getProductsType(){
		$producttype = Mage::getStoreConfig('productlisting/product_setting/type_product');
		return $producttype;
	}
	public function getNumProduct(){
		return (int)Mage::getStoreConfig('productlisting/product_setting/num_products');
	}
	public function getPageTitle(){
		$productType = Mage::getStoreConfig('productlisting/product_setting/type_product');
		$customPageTitle = Mage::getStoreConfig('productlisting/product_setting/title_products');
		$pageTitle = '';
		if (!$customPageTitle) {
			switch ($productType) {
					case 'random':
						$pageTitle = 'Random Products';
						break;
					case 'bestseller':
						$pageTitle = 'Bestseller Products';
						break;
					case 'mostviewed':
						$pageTitle = 'Most Viewed Products';
						break;
					case 'recentlyadded':
						$pageTitle = 'Recently Added';
						break;
					case 'special':
						$pageTitle = 'Special Products';
						break;
					default:
						$pageTitle = 'Random Products';
						break;
				}
		}
		else $pageTitle = $customPageTitle;
		return $pageTitle;
	}
	public function showDescription(){
		return (int)Mage::getStoreConfig('productlisting/product_setting/show_description');
	}
}