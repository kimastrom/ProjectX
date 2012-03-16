 $(document).ready(function(){
	$("#sendByMail").click(function(){
		var valid = '';
		var isr = ' is required.';
		var mail = $("#mailAddress").val();
        var subject = $("#snippetTitle").text();
		//var text = $(".snippet-text").text();
        var text = $("#hidden").text();
		//var text = "snippet-text";

		if (!mail.match(/^([a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,4}$)/i)) {
			valid += '<br />A valid Email'+isr;
		}
		if (subject.length<1) {
			valid += '<br />Subject'+isr;
		}
		if (text.length<1) {
			valid += '<br />Text'+isr;
		}
		if (valid!='') {
			$("#response").fadeIn("slow");
			$("#response").html("Error:"+valid);
		}
		else {
			var datastr ='&mail=' + mail + '&subject=' + subject + '&text=' + text;
			$("#response").css("display", "block");
			$("#response").html("Sending message .... "+datastr);
			$("#response").fadeIn("slow");
			setTimeout("send('"+datastr+"')",2000);
		}
		return false;
	});
});
function send(datastr){
	$.ajax({	
		type: "POST",
		url: "mail.php",
		data: datastr,
		cache: false,
		success: function(html){
		$("#response").fadeIn("slow");
		$("#response").html(html);
		setTimeout('$("#response").fadeOut("slow")',2000);
	}
	});
}
