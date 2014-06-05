$(document).ready(function(){
		
		var a=new Date("October 01, 2012 00:00:00"); //Set the date for the counter
		
		$("#counter").countdown({until:a,layout:'<div class="item four columns"><p>{dn}</p> <p class="days clearfix">{dl}</p></div> <div class="item four columns"><p>{hn}</p> <p class="hours clearfix">{hl}</p></div> <div class="item four columns"><p>{mn}</p> <p class="minutes clearfix">{ml}</p></div> <div class="item four columns"><p>{sn}</p> <p class="seconds clearfix">{sl}</p></div>'});
		
		$("#year").text(a.getFullYear())	
});

jQuery(function($) {
		$('body').on('click','#subscribe',function(){jQuery.ajax({'type':'POST','success':function(data) {
									
		var error = $('p#error');
		var success = $('p#success');
		if(data == 1) {
			error.hide();
			success.fadeIn(1000);
		} else {
			error.fadeIn(1000);
			success.hide();
		} 
		},
		'url':'form.php',		  
		'cache':false,
		'data':jQuery(this).parents("form").serialize()});return false;});
});