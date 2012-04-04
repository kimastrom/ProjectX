//
// basic.js
// ProjectX
//
// Created by Pontus on 2012-03-12.
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


    if($('#mail-wrap').length > 0) {
		var mailFx = new Fx.Slide('mail-wrap', {
			duration: 100,
			transition: Fx.Transitions.linear
		});
		
		mailFx.hide();
		
		//Toogle on click
		$('#mail').click(function() {
			mailFx.toggle();
		});
	}

});//End document ready