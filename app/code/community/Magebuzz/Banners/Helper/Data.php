<?php
class Magebuzz_Banners_Helper_Data extends Mage_Core_Helper_Abstract
{
	const XML_PATH_ENABLE_BANNER                    =   'banners/general/enable_banners';
	const XML_PATH_INCLUDE_JQUERY                    =   'banners/general/include_js';
	const XML_PATH_TITLE_BANNER                     =   'banners/general/show_title_banners';
	const XML_PATH_DESCRIPTION_BANNER               =   'banners/general/show_description_banners';

	const XML_PATH_WIDTH							=	'banners/banners_setting/banner_width';
	const XML_PATH_HEIGHT					  		=	'banners/banners_setting/banner_height';
	const XML_PATH_TRANSITION_TYPE					=	'banners/banners_setting/transition_type';
	const XML_PATH_TRANSITION_SPEED					=	'banners/banners_setting/transition_speed';
	const XML_PATH_THUMBNAIL_WIDTH                  =   'banners/banners_setting/banner_thumnail_width';
	const XML_PATH_THUMBNAIL_HEIGHT                 =   'banners/banners_setting/banner_thumnail_height';

    //const DISPLAY_HOMEPAGE                          = 0;

   
	public function isEnableBanners(){
		return Mage::getStoreConfig(self::XML_PATH_ENABLE_BANNER);
	}
	
	public function includeJqueryLib() {
		return Mage::getStoreConfig(self::XML_PATH_INCLUDE_JQUERY);
	}
	
	public function getTitleBanners(){
		return Mage::getStoreConfig(self::XML_PATH_TITLE_BANNER);
	}
	
	public function getDescriptionBanners(){
		return Mage::getStoreConfig(self::XML_PATH_DESCRIPTION_BANNER);
	}
	
    public function bannerWidth()
    {
        return (int)Mage::getStoreConfig(self::XML_PATH_WIDTH);
    }

    public function bannerHeight()
    {
        return (int)Mage::getStoreConfig(self::XML_PATH_HEIGHT);
    }
    
    public function transitionType()
    {
        return Mage::getStoreConfig(self::XML_PATH_TRANSITION_TYPE);
    }
	
    public function transitionSpeed()
    {
        return Mage::getStoreConfig(self::XML_PATH_TRANSITION_SPEED);
    }

    public function generateBanners(){
        $banners = Mage::getModel('banners/banners')->getCollection()
            ->addStoreFilter(Mage::app()->getStore(true)->getId())
            ->addOrder('main_table.sort_order', 'ASC')
            ->getData();
        
    }

}