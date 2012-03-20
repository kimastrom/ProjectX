//
//  basic.js
//  ProjectX
//
//  Created by Pontus on 2012-03-12.
//

$(document).ready(function(){
	
	$('#about').click(function() {
  		$('#learn-more-wrap').slideToggle('slow');
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