<?php

class Magebuzz_Banners_Block_Adminhtml_Banners_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('banners_form', array('legend'=>Mage::helper('banners')->__('Banners information')));

        $object = Mage::getModel('banners/banners')->load( $this->getRequest()->getParam('id') );
        echo $object;

        $imgPath = Mage::getBaseUrl('media')."Banners/images/".$object['bannerimage'];

        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('banners')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));

        if($object['bannerimage']){
            $fieldset->addField('image', 'label', array(
                'label' => Mage::helper('banners')->__('Banner Image'),
                'name'  =>'image',
                'value'     => $imgPath,
                'after_element_html' => '<img src="'.$imgPath .'" alt=" '. $imgPath .'" height="120" width="120" />',
            ));
        }

        if($object['bannerimage']){
            $fieldset->addField('bannerimage', 'file', array(
                'label'     => Mage::helper('banners')->__('Change Banner'),
                'required'  => false,
                'name'      => 'bannerimage',
            ));
        }else {
            $fieldset->addField('bannerimage', 'file', array(
                'label'     => Mage::helper('banners')->__('Choose Banner'),
                'required'  => false,
                'name'      => 'bannerimage',
            ));
        }

        $fieldset->addField('link', 'text', array(
            'label'     => Mage::helper('banners')->__('Link'),
            'required'  => false,
            'name'      => 'link',
        ));

        $fieldset->addField('target', 'select', array(
            'label'     => Mage::helper('banners')->__('Target'),
            'name'      => 'target',
            'values'    => array(
                array(
                    'value'     => '_self',
                    'label'     => Mage::helper('banners')->__('Open in same window'),
                ),
				array(
                    'value'     => '_blank',
                    'label'     => Mage::helper('banners')->__('Open in new window'),
                ),
            ),
        ));

        $fieldset->addField('sort_order', 'text', array(
            'label'     => Mage::helper('banners')->__('Sort Order'),
            'required'  => false,
            'name'      => 'sort_order',
        ));


        $fieldset->addField('store_id','multiselect',array(
            'name'      => 'stores[]',
            'label'     => Mage::helper('banners')->__('Store View'),
            'title'     => Mage::helper('banners')->__('Store View'),
            'required'  => true,
            'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true)
        ));


        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('banners')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('banners')->__('Enabled'),
                ),

                array(
                    'value'     => 2,
                    'label'     => Mage::helper('banners')->__('Disabled'),
                ),
            ),
        ));

        $fieldset->addField('content', 'editor', array(
            'name'      => 'content',
            'label'     => Mage::helper('banners')->__('Description'),
            'title'     => Mage::helper('banners')->__('Description'),
            'style'     => 'width:400px; height:300px;',
            'wysiwyg'   => false,
            'required'  => true,
        ));

        if ( Mage::getSingleton('adminhtml/session')->getBannersData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getBannersData());
            Mage::getSingleton('adminhtml/session')->setBannersData(null);
        } elseif ( Mage::registry('banners_data') ) {
            $form->setValues(Mage::registry('banners_data')->getData());
        }
        return parent::_prepareForm();
    }
}