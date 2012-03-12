// 
//  basic.js
//  ProjectX
//  
//  Created by Pontus on 2012-03-12.
// 

$(document).ready(function(){	
	
	var aboutFx = new Fx.Slide('learn-more-wrap', {
    	duration: 1000,
    	transition: Fx.Transitions.Bounce.easeOut
	});
	
	aboutFx.hide();
	
	
	//Toogle on click
	$('#about').click(function() {	
		aboutFx.toggle();
	}); 	
});//End document ready