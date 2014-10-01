<?php

    class Magebuzz_Banners_Model_System_Config_Styles
    {
        public function toOptionArray()
        {
            return array(
                array('value' => 'carousel', 'label'=>Mage::helper('adminhtml')->__('Carousel')),
                array('value' => 'fade', 'label'=>Mage::helper('adminhtml')->__('Fade')),
                array('value' => 'thumbnail-view', 'label'=>Mage::helper('adminhtml')->__('Thumbnail View')),
            );
        }
    }

?>