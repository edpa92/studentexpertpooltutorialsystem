$(function(){
	
	$(".toggle-password").click(function(){
		var passwordField = document.getElementById("exampleInputPassword1");
        if (passwordField.type === "password") {
            passwordField.type = "text";
			$("#toggle-password-view").hide();
			$("#toggle-password-hide").show();
        } else {
            passwordField.type = "password";
			$("#toggle-password-view").show();
			$("#toggle-password-hide").hide();
        }
    });
	


	setInterval(function() {
	  $.ajax({
	    url: 'api/MessageGetUnviewedCount.php',
	    method: 'GET',
	    data: {
	      id: idinsstud,
	    },
	    success: function(response) {
	      	      $('#unread_span').text("");
	      if(response.unviewed>0){
				
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

		  $('#messageul').append(
			'<li><hr class="dropdown-divider"></li>'+
			'<li><a class="dropdown-item" href="Chats.php">See all</a></li>');

	      $.each(response, function(index, value) {
		      console.log(value);
		      $('#messageul').prepend(
                '<li><a class="dropdown-item" href="Chats.php?ci='+value.ChatId+'"><small>'+value.NAME+' <span class="badge text-bg-danger">'+value.Unviewed
+'</span></small><br><small class="text-secondary"><em>'+value.TOPMSG
+'</em></small></a></li>'+
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
	
	function addChat(instructorsId, studId, senderinsId, senderstudId, message){
		// Get the form data
		  var formData = {
		    instructorsId: instructorsId,
		    studId:studId,
		    senderstudId:senderstudId,
		    senderinsid:senderinsId,
		    msg:message
		  };
		
		  // Send the form data to the server using AJAX
		  $.ajax({
		    type: 'POST',
		    url: 'api/ChatAdd.php', // Replace with the URL of your server-side script
		    data: formData,
		    success: function(response) {
		      // Handle the response from the server
		      //console.log(response);
		    },
			  error: function(xhr, status, error) {
			    // Handle any errors that occur during the request
			    console.log(error);
			  }
		  });
	}
	
	
	
	
});