$(function() {
  setTimeout(hideSplash, 1000);
 
});

function hideSplash() {
	$.mobile.changePage("#home", "fade");
}
		
updateLogoSize();
$(window).resize(function() {
		updateLogoSize();
});
function updateLogoSize() {
	var img = $('.client_logo');
	var theImage = new Image();
	theImage.src = img.attr('src');
	var imgwidth = theImage.width;
	var imgheight = theImage.height;
	if(imgwidth>90){
	 if($(window).width()<500 && $(window).width()>350)
	  $('.client_logo').attr('style','width: 160%; max-width: 180px; max-height: 60px;');
	 else if($(window).width()<350 && $(window).width()>300)
	  $('.client_logo').attr('style','width: 160%; max-width: 150px; max-height: 60px;');
	 else if($(window).width()<300)
	  $('.client_logo').attr('style','width: 160%; max-width: 120px;');
	 else
	  $('.client_logo').attr('style', 'width: auto !important; max-width:125; max-height: 65px;'); 
	}else{
		if($(window).width()<500 && $(window).width()>300)
			$('.client_logo').attr('style', 'width: auto !important; max-width:70px; max-hight:50px;');
		else if($(window).width()<300)
			$('.client_logo').attr('style', 'width: auto !important; max-width:60px; max-hight:45px;');
		 else
		   $('.client_logo').attr('style', 'width: auto !important; max-width:80px; max-height: 70px;'); 	
	}
}

addToHomescreen({
	lifespan 	: 	0,
	maxDisplayCount : 2,
	displayPace	: 2880
});
