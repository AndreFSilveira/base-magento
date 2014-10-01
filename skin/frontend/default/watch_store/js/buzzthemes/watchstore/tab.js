/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
var $tab = jQuery.noConflict();
jQuery(document).ready(function($tab) {

	//When page loads...
	$tab(".tab_content").hide(); //Hide all content
	$tab("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$tab(".tab_content:first").show(); //Show first tab content
	/* if($("ul.tabs li:first").hasClass('active')){
		$("ul.tabs li:first").css({'border-left':'0 none'});
	}
	else{
		$("ul.tabs").css({'border-left':'0 none'});
	} */
	//On Click Event
	$tab("ul.tabs li").click(function() {
		$tab("ul.tabs li").removeClass("active"); //Remove any "active" class
		$tab(this).addClass("active"); //Add "active" class to selected tab
		$tab(".tab_content").hide(); //Hide all tab content

		var activeTab = $tab(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$tab(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});
	$tab("a.review-tab").click(function() 
	{
	
		$tab("ul.tabs li").removeClass("active"); //Remove any "active" class
		$tab("ul.tabs li.product-review").addClass("active"); //Add "active" class to selected tab
		$tab(".tab_content").hide(); //Hide all tab content 
		
		var activeTab = $tab(this).attr("href"); //Find the href attribute value to identify the active tab + content
		$tab(activeTab).fadeIn(); //Fade in the active ID content
		$tab('#nickname_field').focus(); //Fade in the active ID content
		return false;
	}); 

});