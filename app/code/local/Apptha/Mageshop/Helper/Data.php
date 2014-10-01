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

class Apptha_Mageshop_Helper_Data extends Mage_Core_Helper_Abstract
{
	
	/**
	 * get avaliable blocks
	 *
	 * @return array
	 */
	public function getAttributes()
	{
		return array(
				array(
						'name' => 'product_summary',
						'data' => array(
								'attribute_code'=>'product_summary',
								'type'=>'text',
								'input'=>'textarea',
								'label'=>'Product Summary',
								'group' => 'General',
								'frontend_label' => array(
										'Product Summary',
										'Product Summary',
								),
								'is_required' => 0,
							    'is_unique' => 0,
							    'is_global' =>Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
							    'is_comparable'=>0,
							    'is_wysiwyg_enabled'=>1,
								'is_html_allowed_on_front'=>1,
							    'is_searchable'=>0,
							    'is_used_for_price_rules'=>0,
							    'is_html_allowed_on_front'=>1,
							    'is_visible_on_front'=>1,
							    'used_in_product_listing'=>0,
							    'used_for_sort_by'=>0,
							    'user_defined'=>1,
							    'is_configurable'=>1,
								'is_filterable'=>0,
								'is_filterable_in_search'=>0,
								'is_visible_in_advanced_search'=>1,
								'apply_to'=>array(),
								'source_model'=>null,
								'default_value_text'=>null,
								'default_value_yesno'=>0,
								'default_value_date'=>null,
						)
				),
				array(
					'name' => 'product_specification',	
					'data' => array(
								'attribute_code'=>'product_specification',
								'type'=>'text',
								'input'=>'textarea',
								'group' =>'General',
								'label'=>'Product Specification',
								'frontend_label' => array(
										'Product Specification',
										'Product Specification',
								),
								'is_required' => 0,
							    'is_unique' => 0,
							    'is_global' =>Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
							    'is_comparable'=>0,
							    'is_wysiwyg_enabled'=>1,
								'is_html_allowed_on_front'=>1,
							    'is_searchable'=>0,
							    'is_used_for_price_rules'=>0,
							    'is_html_allowed_on_front'=>1,
							    'is_visible_on_front'=>1,
							    'used_in_product_listing'=>0,
							    'used_for_sort_by'=>0,
							    'user_defined'=>1,
							    'is_configurable'=>1,
								'is_filterable'=>0,
								'is_filterable_in_search'=>0,
								'is_visible_in_advanced_search'=>1,
								'apply_to'=>array(),
								'source_model'=>null,
								'default_value_text'=>null,
								'default_value_yesno'=>0,
								'default_value_date'=>null,
								
							)
				)
		);
	}
	
	/**
	 * get avaliable blocks
	 *
	 * @return array
	 */
	public function getBlocks()
	{
		return array(
				array(
					'name'=>'Footer Links Company',
					'content'=>'<div class="links">
									<div class="block-title"><strong><span>Shopping With Us</span></strong></div>
									<ul>
										<li><a href="{{store url=""}}about-magento-demo-store/">About Us</a></li>
										<li><a href="{{store url=""}}contacts/">Contact Us</a></li>
										<li><a href="{{store url=""}}customer-service/">Customer Service</a></li>
										<li><a href="{{store url=""}}privacy-policy-cookie-restriction-mode/">Privacy Policy</a></li>
										<li><a href="#">Terms and Conditions</a></li>
										<li><a href="#">Frequently Asked Questions</a></li>
									</ul>
								</div>
								<div class="links">
									<div class="block-title"><strong><span>Your Account</span></strong></div>
									<ul>
										<li><a href="{{store url=""}}customer/account/">Your Account</a></li>
										<li><a href="#">Personal Information</a></li>
										<li><a href="{{store url=""}}catalogsearch/term/popular/">Search Terms</a></li>
										<li><a href="{{store url=""}}catalogsearch/advanced/">Advanced Search</a></li>
										<li><a href="{{store url=""}}sales/guest/form/">Order History</a></li>
										<li><a href="{{store url=""}}catalog/seo_sitemap/category/">Sitemap</a></li>
									</ul>
								</div>
								<div class="links">
									<div class="block-title"><strong><span>About Us</span></strong></div>
									<ul>
										<li><a href="{{store url=""}}about-magento-demo-store/">About Tripp</a></li>
										<li><a href="{{store url=""}}contacts/">Contact Us</a></li>
										<li><a href="{{store url=""}}customer-service/">Customer Service</a></li>
										<li><a href="#">Partners</a></li>
										<li><a href="#">Careers</a></li>
										<li><a href="#">Store Finder</a></li>
									</ul>
								</div>'	
				),
				array(
						'name'=>'Footer Top Block',
						'content'=>'<div class="links">
										<ul class="address">
											<li class="navigation"><span>icon</span>#24 Lincon street, Texas, Washington DC, USA</li>
											<li class="mobile"><span>icon</span>+91 - 0987654321</li>
											<li class="email"><span>icon</span>email@gmail.com</li>
										</ul>
									</div>
									<div class="static-block">
										<div class="static-img"><img src="{{skin url=\'images/static-block.png\'}}" alt="#" /></div>
										<div class="foot-logo">
											<div class="logo-img">img</div>
											<p>Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type.</p>
										</div>
									</div>
									<div class="block">
										<div class="block-title"><strong><span>Social Links</span></strong></div>
										<p>Follow us on social media to get unique and exclusive deals and discounts</p>
										<ul>
											<li class="you-tube"><a title="Youtube" target="_blank" href="#">youtube</a></li>
											<li class="facebook"><a title="Facebook" target="_blank" href="#">fb</a></li>
											<li class="twitter"><a title="Twitter" target="_blank" href="#">twit</a></li>
											<li class="google-plus"><a title="Google Plus" target="_blank" href="#">googleplus</a></li>
										</ul>
									</div>'
				),
				array(
						'name'=>'Footer Payment Method',
						'content'=>'<div class="payment-method">
										<ul>
											<li class="bank"><span title="Bank Transfer">icon</span></li>
											<li class="visa"><span title="Visa Card">icon</span></li>
											<li class="master"><span title="Master Card">icon</span></li>
											<li class="pay"><span title="Paypal">icon</span></li>
											<li class="american"><span title="American">icon</span></li>
										</ul>
									</div>'
				),
				array(
						'name'=>'Subcategory Listing',
						'content'=>'{{block type="catalog/navigation" template="catalog/navigation/subcategory_listing.phtml"}}'
				),
				array(
						'name'=>'Home Category Images',
						'content'=>'<div class="middle-ads">
										<div class="middle-ads-inner">
											<div class="ads-image first"><a href="{{store url=\'men.html\'}}"><img src="{{media url="mageshop/category-images/middle-ad-3.png"}}" alt="" /></a></div>
											<div class="ads-image "><a href="{{store url=\'children.html\'}}"><img src="{{media url="mageshop/category-images/middle-ad-2.png"}}" alt="" /></a></div>
											<div class="ads-image last"><a href="{{store url=\'woman.html\'}}"><img src="{{media url="mageshop/category-images/middle-ad-1.png"}}" alt="" /></a></div>
										</div>
									</div>'
				),
				array(
						'name'=>'Home SitePolicy Block',
						'content'=>'<div class="site-policy">
										<div class="site-policy-inner">
											<div class="policy first"><a href="#">image</a>
												<h2>free shipping</h2>
												<p>This is Photoshop&rsquo;s version of Lorem Ipsum. Proin gravida nibh vel velit. we have the perfect one</p>
											</div>
											<div class="policy"><a href="#">image</a>
												<h2>Money Back Guarantee</h2>
												<p>This is Photoshop&rsquo;s version of Lorem Ipsum. Proin gravida nibh vel velit. we have the perfect one</p>
											</div>
											<div class="policy last"><a href="#">image</a>
												<h2>easy order</h2>
												<p>This is Photoshop&rsquo;s version of Lorem Ipsum. Proin gravida nibh vel velit. we have the perfect one</p>
											</div>
										</div>
									</div>'
				),
				array(
						'name'=>'Header social links',
						'content'=>'<ul>
										<li class="you-tube"><a title="Youtube" target="_blank" href="#">text</a></li>
										<li class="facebook"><a title="Facebook" target="_blank" href="#">text</a></li>
										<li class="twitter"><a title="Twitter" target="_blank" href="#">text</a></li>
										<li class="google-plus"><a title="Google Plus" target="_blank" href="#">text</a></li>
									</ul>'
				),
				
		);
	}
}
