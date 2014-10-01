<?php
class Magebuzz_Productlisting_RecentlyaddedController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
}