<?php
/*
* Copyright (c) 2013 www.magebuzz.com
*/
class Magebuzz_Manufacturer_Block_Sidebar extends Magebuzz_Manufacturer_Block_Manufacturer {
	public function _construct() {
		$this->setTemplate('manufacturer/sidebar.phtml');
		return parent::_construct();
	}
}