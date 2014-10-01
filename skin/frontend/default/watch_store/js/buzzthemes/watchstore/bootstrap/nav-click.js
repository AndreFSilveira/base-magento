jQuery(document).ready(function () {
	
	jQuery('.nav-top .dropdown-toggle').click(function(){
	
	if (!jQuery(this).hasClass('active')){				  
		jQuery('.nav-top .dropdown-menu').slideToggle();
		jQuery('.nav-top .dropdown-toggle').addClass('active');
	}
	else if (jQuery(this).hasClass('active')) {
		jQuery('.nav-top .dropdown-menu').slideToggle();
		jQuery('.nav-top .dropdown-toggle').removeClass('active');
	}
	});
	
	
	jQuery( ".nav-top .dropdown-menu > li.level0.parent" ).append( "<a class='right show-cat' href='javascript://'>&nbsp;</a>" );
	
	jQuery('.nav-top .dropdown-menu > li > a.show-cat').click(function(){
	jQuery('.nav-top .dropdown-menu li ul.level0').slideUp();
	if (!jQuery(this).hasClass('active')){				  
		jQuery(this).prev().slideToggle();
		jQuery('.nav-top .dropdown-menu li a.show-cat').removeClass('active');
		jQuery(this).addClass('active');
	}
	else if (jQuery(this).hasClass('active')) {
		jQuery(this).removeClass('active');
	}
	});
});