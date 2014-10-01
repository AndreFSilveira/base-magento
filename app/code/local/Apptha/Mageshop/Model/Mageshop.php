<?php
/**
* Apptha
*
* NOTICE OF LICENSE
*
* This source file is subject to the EULA
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://www.apptha.com/LICENSE.txt
*
* ==============================================================
*                 MAGENTO EDITION USAGE NOTICE
* ==============================================================
* This package designed for Magento COMMUNITY edition
* Apptha does not guarantee correct work of this extension
* on any other Magento edition except Magento COMMUNITY edition.
* Apptha does not provide extension support in case of
* incorrect edition usage.
* ==============================================================
*
* @category    Apptha
* @package     Apptha_Mageshop
* @version     0.1.0
* @author      Apptha Team <developers@contus.in>
* @copyright   Copyright (c) 2014 Apptha. (http://www.apptha.com)
* @license     http://www.apptha.com/LICENSE.txt
*
*
*/

class Apptha_Mageshop_Model_Mageshop extends Mage_Core_Model_Abstract
{
	/*
	 * @var Mage_Core_Model_Resource_Setup  $_resource
	*/
	protected $_resource;
	/*
	 * @var Magento_Db_Adapter_Pdo_Mysql  $_connection 
	 */
	protected $_connection;
	
	/**
	 * init the model
	 *
	 */
	public function _construct()
	{
		$this->_resource = new Mage_Core_Model_Resource_Setup();
		
		$this->_connection = $this->_resource->getConnection();
	}
	
	/**
	 * Add the required block to the site
	 *
	 * @return null
	 */
	public function insert()
	{
		$this->addBlock();
		$this->addAttributeToProduct();
		Mage::app()->cleanCache(array(Mage_Core_Model_Translate::CACHE_TAG));
	}
	
	
	/*
	 * Insert the block

	*
	*/
	protected function addBlock() {
		
		$blocks = Mage::helper('mageshop')->getBlocks();
		foreach($blocks as $block){
			$this->addToBlockTable($block['name'],$block['content']);
		}
	}
	
	/*
	 * Insert Attribute To Product
	*
	*/
	protected function addAttributeToProduct(){
	
		$entityTypeId = Mage::getModel('eav/entity')->setType(Mage_Catalog_Model_Product::ENTITY)->getTypeId();
		
		$attributes = Mage::helper('mageshop')->getAttributes();
		
		$eav_model = Mage::getModel('eav/entity_setup','core_setup');
	
		foreach($attributes as $attribute){
			
			$eav_model->removeAttribute('catalog_product',$attribute['name']);
			
			$model = Mage::getModel('catalog/resource_eav_attribute');
			
			$model->setEntityTypeId($entityTypeId);
			$model->setIsUserDefined(1);
			
			$model->addData($attribute['data']);
			$model->save();
			
			$eav_model->addAttribute('catalog_product',$attribute['name'],$attribute['data']);
		}
	}
	
	/*
	 * Insert the block to the block table
	 * 
	 * @param String $blockname
	 * @param String $content 
	 * 
	 */
	protected function addToBlockTable($blockname,$content){

		$identifier = str_replace(' ','_',strtolower($blockname));
		$select = $this->_connection->select()
					->from($this->_resource->getTable('cms/block'))
					->where('identifier = ?',$identifier);
		$avaliable_blocks = $this->_connection->query($select)->fetchAll();	

		if(!count($avaliable_blocks)){
			
			$this->_connection->insert($this->_resource->getTable('cms/block'), array(
					'title'             => $blockname,
					'identifier'        => $identifier,
					'content'           => $content,
					'is_active'			=> 1,
					'creation_time'     => now(),
					'update_time'       => now(),
			));
			$this->_connection->insert($this->_resource->getTable('cms/block_store'), array(
					'block_id'   => $this->_connection->lastInsertId(),
					'store_id'  => 0
			));
			
		}else{	
			
			foreach($avaliable_blocks as $block){	
				
				$this->_connection->update($this->_resource->getTable('cms/block'), array(
						'title'             => $blockname,
						'content'           => $content,
						'is_active'			=> 1,
						'creation_time'     => now(),
						'update_time'       => now(),
				)," block_id =  ".$block['block_id']);
			
			}
		}
	}

}
