<?php
/*
* Copyright (c) 2013 www.magebuzz.com
*/
class Magebuzz_Manufacturer_Block_Adminhtml_Manufacturer_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {
  protected function _prepareForm() {
    $form = new Varien_Data_Form();
    $this->setForm($form);
    $fieldset = $form->addFieldset('manufacturer_form', array('legend'=>Mage::helper('manufacturer')->__('Item information')));
    $manufacturer_data = array();
    $model = Mage::registry('manufacturer_data');
    if ( Mage::getSingleton('adminhtml/session')->getManufacturerData() ) {
      $manufacturer_data = Mage::getSingleton('adminhtml/session')->getManufacturerData();      
      Mage::getSingleton('adminhtml/session')->setManufacturerData(null);
    } elseif ( Mage::registry('manufacturer_data') ) {
      $manufacturer_data = Mage::registry('manufacturer_data')->getData();		      
    }

    if ($manufacturer_data['image'] && $manufacturer_data['image'] != '') {
      $manufacturer_data['image'] = 'manufacturer/' . $manufacturer_data['image'];
    }
    if($manufacturer_data['manufacturer_id']== null || !isset($manufacturer_data['manufacturer_id'])){
      $fieldset->addField('name', 'text', array(
      'label'     => Mage::helper('manufacturer')->__('Name'),
      'class'     => 'required-entry',
      'required'  => true,
      'name'      => 'name',
      ));
    }else{
      $fieldset->addField('name', 'text', array(
      'label'     => Mage::helper('manufacturer')->__('Name'),
      'class'     => 'required-entry',
      'required'  => true,
      'name'      => 'name',
      'readonly'	=> 'readonly',
      ));
    }
    $fieldset->addField('identifier', 'text', array(
    'label'     => Mage::helper('manufacturer')->__('URL Identifier'),
    'class'     => 'required-entry',
    'required'  => true,
    'name'      => 'identifier',
    /* 'readonly'	=> 'readonly', */
    ));                                          
    $fieldset->addField('image', 'image', array(
    'label'     => Mage::helper('manufacturer')->__('Image'),
    'required'  => false,
    'name'      => 'image',				
    ));
    if (!Mage::app()->isSingleStoreMode()) 
    {
      $fieldset->addField('store_id', 'multiselect', array(
      'name'      => 'stores[]',
      'label'     => Mage::helper('cms')->__('Store View'),
      'title'     => Mage::helper('cms')->__('Store View'),
      'required'  => true,
      'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true)
      ));
    }
    else 
    {
      $fieldset->addField('store_id', 'hidden', array(
      'name'      => 'stores[]',
      'value'     => Mage::app()->getStore(true)->getId()
      ));
    }
    $fieldset->addField('website', 'text', array(
    'label'     => Mage::helper('manufacturer')->__('Website'),
    'required'  => false,
    'name'      => 'website',
    ));
    $fieldset->addField('is_featured', 'select', array(
    'label'     => Mage::helper('manufacturer')->__('Featured Manufacturer'),
    'name'      => 'is_featured',
    'values'    => array(
    array(
    'value'     => 1,
    'label'     => Mage::helper('manufacturer')->__('Yes'),
    ),
    array(
    'value'     => 0,
    'label'     => Mage::helper('manufacturer')->__('No'),
    ),
    ),
    ));

    $fieldset->addField('status', 'select', array(
    'label'     => Mage::helper('manufacturer')->__('Status'),
    'name'      => 'status',
    'values'    => array(
    array(
    'value'     => 1,
    'label'     => Mage::helper('manufacturer')->__('Enabled'),
    ),
    array(
    'value'     => 0,
    'label'     => Mage::helper('manufacturer')->__('Disabled'),
    ),
    ),
    ));

    $fieldset->addField('description', 'editor', array(
    'name'      => 'description',
    'label'     => Mage::helper('manufacturer')->__('Description'),
    'title'     => Mage::helper('manufacturer')->__('Description'),
    'style'     => 'width:700px; height:150px;',
    'wysiwyg'   => false,
    'required'  => false,
    ));

    $form->setValues($manufacturer_data);
    return parent::_prepareForm();
  }
}