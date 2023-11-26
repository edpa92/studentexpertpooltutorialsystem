$(function(){

	
	async function InitChatroom(){
		textDiv.textContent = "Please wait, we are joining the meeting";

		  // API call to create meeting
		  const url = `https://api.videosdk.live/v2/rooms`;
		  const options = {
		    method: "POST",
		    headers: { Authorization: TOKEN, "Content-Type": "application/json" },
		  };
		
		  const { roomId } = await fetch(url, options)
		    .then((response) => response.json())
		    .catch((error) => alert("Network error", error));
		  meetingId = roomId;
		
		
		  if (meetingId != 'undefined' && roomId!= 'undefined') {
		 	addChat(materialsId,instructorsId, studId, senderinsId, senderstudId, "meeting ID:"+ meetingId);
		 }		  
		  
		 initializeMeeting();
	}
	
	function addChat(materialsId,instructorsId, studId, senderinsId, senderstudId, message){
		// Get the form data
		  var formData = {
		    materialsId: materialsId,
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
	
	
InitChatroom();
	
});