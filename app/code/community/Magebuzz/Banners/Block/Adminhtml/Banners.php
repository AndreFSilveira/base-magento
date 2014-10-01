<?php
class Magebuzz_Banners_Block_Adminhtml_Banners extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_banners';
    $this->_blockGroup = 'banners';
    $this->_headerText = Mage::helper('banners')->__('Manage Banner');
    $this->_addButtonLabel = Mage::helper('banners')->__('Add New Banner');
    parent::__construct();
  }
}