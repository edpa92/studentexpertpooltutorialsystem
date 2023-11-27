<?php
session_start();

if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}


if (!isset($_GET['m']) || $_GET['m']=="") {
    header("location: 404.php");
    exit();
}

if (!isset($_SESSION["RoleSEPTS"]) || ($_SESSION["RoleSEPTS"] != "Instructor" && $_SESSION["RoleSEPTS"] != "Student")) {
    header("location: 404.php");
    exit();
}


require_once("model/ChatModel.php");
$chatM= new ChatModel();


if (is_null($chatM->getChatMessageHasMeetingId($chatM->escapeString($_GET['m'])))) {
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
    
    <script src="js/index.js"></script>
    
<script>
$(function(){
	$("#textDiv").text("Joining the meeting...");
	meetingId="<?=($chatM->escapeString($_GET['m']))?>";
	initializeMeeting();
});    
</script>
    