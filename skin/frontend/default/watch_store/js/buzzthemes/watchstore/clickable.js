
jQuery(document).ready(function () {
	jQuery('.block-shop-by-content > .block-title').click(function(){
	jQuery('.block-shop-by-content > .block-content').slideUp();
	if (!jQuery(this).hasClass('active')){				  
		jQuery(this).next().slideToggle();
		jQuery('.block-shop-by-content > .block-title').removeClass('active');
		jQuery(this).addClass('active');
	}
	else if (jQuery(this).hasClass('active')) {
		jQuery(this).removeClass('active');
	}
	});
});


jQuery(document).ready(function () {
	jQuery('.footer-links > div > div > div > .page-title-footer').click(function(){
	jQuery('.footer-links > div > div > div > .block-content-footer').slideUp();
	if (!jQuery(this).hasClass('active')){				  
		jQuery(this).next().slideToggle();
		jQuery('.footer-links > div > div > div > .page-title-footer').removeClass('active');
		jQuery(this).addClass('active');
	}
	else if (jQuery(this).hasClass('active')) {
		jQuery(this).removeClass('active');
	}
	});
});

jQuery(document).ready(function () {
	jQuery('.sidebar > .block > .block-title').click(function(){
	 if (!jQuery(this).hasClass('active')){				  
			jQuery(this).next().slideToggle();
		  jQuery(this).addClass('active'); 
	} 
	   else if (jQuery(this).hasClass('active')) {
			jQuery(this).next().slideToggle();
			jQuery(this).removeClass('active');
	}   
	});
});

jQuery(document).ready(function () {
	jQuery('.products-grid .product-info .btn-hover').click(function(){
	 if (!jQuery(this).hasClass('active')){				  
			jQuery(this).prev().addClass('active');
		  jQuery(this).addClass('active');
	} 
	   else if (jQuery(this).hasClass('active')) {
			jQuery(this).prev().removeClass('active');
			jQuery(this).removeClass('active');
	}   
	});
	
	/*-- detail product in my cart sidebar  --*/
	
	jQuery('.sidebar .block-cart .truncated a.details').click(function(){
	 if (!jQuery(this).hasClass('active')){				  
			jQuery(this).next().slideToggle();
		  jQuery(this).addClass('active'); 
	} 
	   else if (jQuery(this).hasClass('active')) {
			jQuery(this).next().slideToggle();
			jQuery(this).removeClass('active');
	}   
	});
	
	
	
});
















