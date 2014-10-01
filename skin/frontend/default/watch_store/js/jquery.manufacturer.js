var $k = jQuery.noConflict();
$k(function(){

    var widthwd = $k(window).width();
		/* alert(widthwd); */
		var widthSl = widthwd/3;
		var minSl = 3;
		
			
			if($k(window).innerWidth() < 550){
				minSl = 2;
				widthSl= widthwd/2;
				
			}
			if($k(window).innerWidth() < 400){
				minSl = 1;
				widthSl= widthwd;
				
			}
			

    $k('.list-manufacturer').bxSlider({
      maxSlides:6,
			minSlides:minSl,
			slideWidth: widthSl,
	    moveSlides:1,
      preloadImages: 'visible', 
      pager:false,
      controls:true
    });
  });