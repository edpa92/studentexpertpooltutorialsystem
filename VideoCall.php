<?php
session_start();

if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}

require_once("views/header.php");
require_once("views/navi.php");
?>
<div class="container">
		<div id="join-screen">
          <!-- Create new Meeting Button -->
          <button id="createMeetingBtn">New Meeting</button>
          OR
          <!-- Join existing Meeting -->
          <input type="text" id="meetingIdTxt" placeholder="Enter Meeting id" />
          <button id="joinBtn">Join Meeting</button>
   		</div>



    <!-- for Managing meeting status -->
    <div id="textDiv"></div>


    <div id="grid-screen" style="display: none">
      <!-- To Display MeetingId -->
      <h3 id="meetingIdHeading"></h3>

      <!-- Controllers -->
      <button id="leaveBtn">Leave</button>
      <button id="toggleMicBtn">Toggle Mic</button>
      <button id="toggleWebCamBtn">Toggle WebCam</button>

      <!-- render Video -->
      <div class="row" id="videoContainer"></div>
    </div>

    <!-- Add VideoSDK script -->
    <script src="https://sdk.videosdk.live/js-sdk/0.0.67/videosdk.js"></script>
    <script src="js/config.js"></script>
    <script src="js/index.js"></script>

</div>
<?php 
require_once("views/footer.php");    
?>