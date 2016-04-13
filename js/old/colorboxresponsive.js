var myEfficientFn = debounce(function() {
	               var html = $("#inline_content").html();	
		           var winWidth=$(window).width();						
			       			 
					 if ($("#colorbox").css("display")=="block") {  
					    var html = $("#inline_content").html();		
						var winWidth=$(window).width();				 
						if(winWidth<1024){
                             					
							$.colorbox({html:html, reposition:true , innerHeight:100, width:"80%"});
						 } else {
							  
							 $.colorbox({html:html, reposition:true , innerHeight:100, width:"30%"});
						 }
					}
			}, 250);

window.addEventListener('resize', myEfficientFn);