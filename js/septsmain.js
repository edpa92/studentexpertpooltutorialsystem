$(function(){
	
	setInterval(function() {
	  $.ajax({
	    url: 'api/MessageGetUnviewedCount.php',
	    method: 'GET',
	    data: {
	      id: idinsstud,
	    },
	    success: function(response) {
	      	      
	      if(response.unviewed>0){
			
				//console.log(response.unviewed);
				sessionStorage.setItem('unread_msg', response.unviewed);
				$('#unread_span').text("");
		      	$('#unread_span').text(response.unviewed);
	      }
	      
	    },
	    error: function(xhr, status, error) {
	      // Handle any errors here
	    }
	  });
	}, 30000); // 60000 milliseconds = 1 minute
	
	
	function getAllUnreadMsg(idinsstud){
		$.ajax({
	    url: 'api/MessageGetUnviewed.php',
	    method: 'GET',
	    data: {
	      id: idinsstud,
	    },
	    success: function(response) {
	     	      
		  $('#messageul').html('');
	      $.each(response, function(index, value) {
		      //console.log(value);
		      $('#messageul').prepend(
                '<li><a class="dropdown-item" href="#"><small>'+value.NAME+' <span class="badge text-bg-danger">'+value.Unviewed
+'</span></small><br><small class="text-secondary"><em>'+value.TOPMSG+'</em></small></a></li>'+
                '<li><hr class="dropdown-divider"></li>');
		   });
	
	      
	    },
	    error: function(xhr, status, error) {
	      // Handle any errors here
	    }
	  });
	}
	
	$('#msg_menu').click(function(){
		getAllUnreadMsg(idinsstud);		
	});
	
});