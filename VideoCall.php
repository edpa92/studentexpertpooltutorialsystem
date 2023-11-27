<?php
session_start();

if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}


if (!isset($_GET['i']) || $_GET['i']=="" || !isset($_GET['s']) || $_GET['s']=="") {
    header("location: 404.php");
    exit();
}

if (!isset($_SESSION["RoleSEPTS"]) || ($_SESSION["RoleSEPTS"] != "Instructor" && $_SESSION["RoleSEPTS"] != "Student")) {
    header("location: 404.php");
    exit();
}

require_once("model/StudentModel.php");
$studM= new StudentModel();


require_once("model/InstructorModel.php");
$insM= new InstructorModel();


if (is_null($studM->getStudent($studM->escapeString($_GET['s']))) || is_null($insM->getInstructor($studM->escapeString($_GET['i'])))) {
    header("location: 404.php");
    exit();
}


require_once("views/header.php");
require_once("views/navi.php");
?>
<div class="container">
	<div class="row">
		<div class="col-lg-8 col-md-6 col-sm-12">
		
		          <!-- for Managing meeting status -->
   				<div id="textDiv"></div>
    		      <!-- To Display MeetingId -->
          		<h3 class="text-center" id="meetingIdHeading"></h3>
    			
           		 <div id="grid-screen" style="display: none">                  
                      <!-- Controllers -->
                      <button id="leaveBtn">Leave</button>
                      <button id="toggleMicBtn">Toggle Mic</button>
                      <button id="toggleWebCamBtn">Toggle WebCam</button>        
                      <!-- render Video -->
                 	 <div class="row" id="videoContainer"></div>
                 </div>
    		
		</div>
		<div class="col-lg-4 col-md-6 col-sm-12">
    	</div>
	
    </div>

    

</div>
<?php 
require_once("views/footer.php");    
?><!-- Add VideoSDK script -->
    <script >
       	
    	
    	let instructorsId="<?=$_GET['i'];?>";    	
    	let studId="<?=$_GET['s'];?>";
    	
    	let senderinsId="<?=($_SESSION["RoleSEPTS"] == "Instructor"?$_SESSION["EmpIdSEPTS"]:0) ?>";
    	let senderstudId="<?=($_SESSION["RoleSEPTS"] == "Student"?$_SESSION["StudentId"]:0) ?>";
    </script>
    <script src="js/index.js"></script>
    
    <script>
    $(function(){

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
		
		
		 initializeMeeting();
		 
		  if (meetingId != 'undefined' && roomId!= 'undefined') {
		 	addChat(instructorsId, studId, senderinsId, senderstudId, "meeting ID:"+ meetingId);
		 }		  
		  
	}
	
	
	
	
InitChatroom();
	
});
    
    </script>
    