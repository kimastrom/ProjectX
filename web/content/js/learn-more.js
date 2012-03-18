//
//  basic.js
//  ProjectX
//
//  Created by Pontus on 2012-03-12.
//

$(document).ready(function(){
	
	//About page from menu
	var aboutFx = new Fx.Slide('learn-more-wrap', {
		duration: 1000,
		transition: Fx.Transitions.easeOut
	});
	
	aboutFx.hide();
	
	//Toogle on click
	$('#about').click(function() {
		aboutFx.toggle();
	});
	$('#close-learn-more').click(function() {
		aboutFx.toggle();
	});

	if($('#report-wrap').length > 0) {
		//About page from menu
		var reportFx = new Fx.Slide('report-wrap', {
			duration: 100,
			transition: Fx.Transitions.linear
		});
		
		reportFx.hide();
		
		//Toogle on click
		$('#report').click(function() {
			reportFx.toggle();
		});
	}

		
});//End document ready