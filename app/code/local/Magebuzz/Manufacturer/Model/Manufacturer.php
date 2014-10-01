<?php
/*
* Copyright (c) 2013 www.magebuzz.com
*/
class Magebuzz_Manufacturer_Model_Manufacturer extends Mage_Core_Model_Abstract {
  public function _construct() {
    parent::_construct();
    $this->_init('manufacturer/manufacturer');
  }

  protected function _afterLoad()
  {
    parent::_afterLoad();
    $this->setData('store_id', $this->getResource()->getStoreId($this->getId()));
  }

  public function getSelectedProductIds() {
    $produtIds = array();
    $collection = Mage::getModel('catalog/product')->getCollection()
    ->addFieldToFilter(Mage::helper('manufacturer')->getConfigAttributrCode(), $this->getOptionId());
    if(count($collection)) {
      foreach($collection as $item) {
        $produtIds[] = $item->getEntityId();
      }
    }
    return $produtIds;
  }

  public function loadByOptionId($optionId) {
    $manufacturer = Mage::getModel('manufacturer/manufacturer')->getCollection()
    ->addFieldToFilter('option_id', $optionId)
    ->getFirstItem()
    ->load();
    return $manufacturer;
  }

  public function compareProductList($newarray,$oldarray,$manufaturer_option){
    $productModle = Mage::getModel('catalog/product');
    $insert = array_diff($newarray, $oldarray);
    $delete = array_diff($oldarray, $newarray);   
    $resource = Mage::getSingleton('core/resource');
    $writeConnection = $resource->getConnection('core_write');           
    if(isset($newarray)){
      if ($delete) {
        foreach($delete as $del)
        {
          $where='catalog_product_entity_int.value = '.$manufaturer_option.' AND catalog_product_entity_int.entity_id = '.$del;      
          $writeConnection->delete('catalog_product_entity_int', $where);
        }
      }
      if ($insert) {
        $attribute = Mage::getModel('eav/entity_attribute')
        ->loadByCode('catalog_product', $this->_hepper()->getConfigAttributrCode())->getAttributeId();                              
        $data = array();
        foreach ($insert as $pid) {
          $product = $productModle->load($pid);
          $productData = $product->getData()        ;
          $manufac_id = $productData[$this->_hepper()->getConfigAttributrCode()];                     
          if($manufac_id != null || $manufac_id > 0)
          {
            $where='catalog_product_entity_int.value = '.$manufac_id.' AND catalog_product_entity_int.entity_id = '.$pid;      
            $writeConnection->delete('catalog_product_entity_int', $where);
          }
          $data[] = array(
          'entity_id'  => $pid,
          'value' => $manufaturer_option,
          'store_id' => 0,
          'entity_type_id' => $product->getEntityTypeId(),
          'attribute_id' => $attribute
          );       
        }
        if(count($data)>0)
        {
          $writeConnection->insertMultiple('catalog_product_entity_int', $data);
        }      
      }
    }
  }
  public function addManufacturerOption($opdata){

    $attribute = Mage::getModel('eav/entity_attribute')
    ->loadByCode('catalog_product', $this->_hepper()->getConfigAttributrCode())->getAttributeId();
    $resource = Mage::getSingleton('core/resource');
    $writeConnection = $resource->getConnection('core_write');
    $attributeOption = array(
    'attribute_id' => $attribute,
    'sort_order' => 0,
    );
    $writeConnection->insert('eav_attribute_option', $attributeOption);
    $lastInsertId = $writeConnection->lastInsertId();
    foreach($opdata['store_id'] as $storeId){
      $attOptionValue[] = array(
      'option_id'=>$lastInsertId,
      'value'    =>$opdata['manufacturerName'],
      'store_id' => $storeId,
      );
    }
    if(isset($attOptionValue)){
      $writeConnection->insertMultiple('eav_attribute_option_value', $attOptionValue);
    }
    return $lastInsertId;
  }
  public function deleteManufacturerOption($manufacturer){
    $manufacturerModel = $this->load($manufacturer);
    $optionId = $manufacturerModel->getOptionId();
    $resource = Mage::getSingleton('core/resource');
    $writeConnection = $resource->getConnection('core_write');
    $whereValue='eav_attribute_option_value.option_id = '.$optionId;      
    $writeConnection->delete('eav_attribute_option_value', $whereValue);
    $whereOption='eav_attribute_option.option_id = '.$optionId;      
    $writeConnection->delete('eav_attribute_option', $whereOption);
  }

  public function getAllManufacturer($listOption){
    $collection = $this->getCollection()->getData();
    if(count($collection)>0){
      $listManufacturer = array();
      foreach($collection as $manufacturer){
        $listManufacturer[] = $manufacturer['option_id'];
      }
      $options = array();
      foreach($listOption as $option){
        $options[] = $option['value'];
      }
      $delete = array_diff($listManufacturer,$options);      
      foreach($delete as $del){
        $this->load($del, 'option_id')->delete();
      }
    }
    return true;
  }
  protected function _hepper(){
    return Mage::helper('manufacturer');
  }
}