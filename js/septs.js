/*
$(function(){
	//var pointsArr = [];
		  var totalPoints=0
	$(document).on('click', '#addQ', function(){
	 
	 var q=$("#q").html();	 	 
	 	$("#cardbodyQ").append(q);	  
	});
	

	
	$(document).on('click', '.removebtn', function() {
		var pos = $('.removebtn').index(this);		 
			$('.q:eq('+(pos)+')').remove();
	});
	
	$(document).on('focusout', '.pointstxt', function() {
		 
    	var totalValue = 0;
	    $('.pointstxt').each(function() {
	      var textboxValue = $(this).val();
	      console.log(textboxValue);
	      if (!isNaN(parseFloat(textboxValue))) {
	      totalValue += parseFloat(textboxValue);
	      }
	    });
    			
		$("#totalitem").val(totalValue);
		  
	});
	
	
});*/