<?php

class Magebuzz_Productlisting_Model_Session extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productslider');
    }
}