<?php
class Magebuzz_Banners_Block_Banners extends Mage_Core_Block_Template
{
	public function __construct() {
			parent::__construct();
			$collection = Mage::getModel('banners/banners')->getCollection();
			$collection->addStoreFilter(Mage::app()->getStore(true)->getId());
			$collection->setOrder('sort_order', 'ASC');
			$this->setBanners($collection);
			return $this;
	}
	public function _prepareLayout() {
		return parent::_prepareLayout();
	}
	public function getBanners()
	{
			if (!$this->hasData('banners')) {
					$this->setData('banners', Mage::registry('banners'));
			}
			return $this->getData('banners');
	}
}