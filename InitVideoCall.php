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
    
    <script>
      var script = document.createElement("script");
      script.type = "text/javascript";
      //
      script.addEventListener("load", function (event) {
        // Initialize the factory function
        const meeting = new VideoSDKMeeting();

        // Set apikey, meetingId and participant name
        const apiKey = "617d056e-934a-4d45-8bb0-c1a104fa60e2"; // generated from app.videosdk.live
        const meetingId = "milkyway";
        const name = "John Doe";

        const config = {
          name: name,
          apiKey: apiKey,
          meetingId: meetingId,

          region: "sg001", // region for new meeting

          containerId: null,
          redirectOnLeave: "https://www.videosdk.live/",

          micEnabled: true,
          webcamEnabled: true,
          participantCanToggleSelfWebcam: true,
          participantCanToggleSelfMic: true,
          participantCanLeave: true, // if false, leave button won't be visible

          chatEnabled: true,
          screenShareEnabled: true,
          pollEnabled: true,
          whiteboardEnabled: true,
          raiseHandEnabled: true,

          recording: {
            autoStart: false, // auto start recording on participant joined
            enabled: false,
            webhookUrl: "https://www.videosdk.live/callback",
            awsDirPath: `/meeting-recordings/${meetingId}/`, // automatically save recording in this s3 path
          },

          livestream: {
            autoStart: false,
            enabled: fasle,
          },

          layout: {
            type: "SPOTLIGHT", // "SPOTLIGHT" | "SIDEBAR" | "GRID"
            priority: "PIN", // "SPEAKER" | "PIN",
            // gridSize: 3,
          },

          branding: {
            enabled: true,
            logoURL:
              "https://static.zujonow.com/videosdk.live/videosdk_logo_circle_big.png",
            name: "Prebuilt",
            poweredBy: false,
          },

          permissions: {
            pin: true,
            askToJoin: false, // Ask joined participants for entry in meeting
            toggleParticipantMic: true, // Can toggle other participant's mic
            toggleParticipantWebcam: true, // Can toggle other participant's webcam
            drawOnWhiteboard: true, // Can draw on whiteboard
            toggleWhiteboard: true, // Can toggle whiteboard
            toggleRecording: true, // Can toggle meeting recording
            toggleLivestream: true, //can toggle live stream
            removeParticipant: true, // Can remove participant
            endMeeting: true, // Can end meeting
            changeLayout: true, //can change layout
          },

          joinScreen: {
            visible: true, // Show the join screen ?
            title: "Daily scrum", // Meeting title
            meetingUrl: window.location.href, // Meeting joining url
          },

          leftScreen: {
            // visible when redirect on leave not provieded
            actionButton: {
              // optional action button
              label: "Video SDK Live", // action button label
              href: "https://videosdk.live/", // action button href
            },
          },

          notificationSoundEnabled: true,

          debug: true, // pop up error during invalid config or netwrok error

          maxResolution: "sd", // "hd" or "sd"
        };

        meeting.init(config);
      });

      script.src ="https://sdk.videosdk.live/rtc-js-prebuilt/0.3.31/rtc-js-prebuilt.js";
      document.getElementsByTagName('head')[0].appendChild(script);
    </script>
</div>
<?php 
require_once("views/footer.php");    
?>