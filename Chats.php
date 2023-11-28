<?php
session_start();

if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}

if (!isset($_SESSION["RoleSEPTS"]) || ($_SESSION["RoleSEPTS"] != "Instructor" && $_SESSION["RoleSEPTS"] != "Student")) {
    header("location: 404.php");
    exit();
}

require_once("model/ChatModel.php");
$chatM= new ChatModel();


$ins_id=($_SESSION["RoleSEPTS"] == "Instructor"&& isset($_SESSION["EmpIdSEPTS"])?$_SESSION["EmpIdSEPTS"]:0);
$stud_id=($_SESSION["RoleSEPTS"] == "Student"&& isset($_SESSION["StudentId"])?$_SESSION["StudentId"]:0);


if ($chatM->isRequestPost()) {
    
   
}

require_once("views/header.php");
require_once("views/navi.php");
?>
    <div class="container">
    	<h4 class="">Chat Messages</h4>
    	<div class="row">
    		<div class="col-sm-12 col-md-6 col-lg-4 " >
    			<div class="border flex-nowrap overflow-auto p-2" style="height: 500px;">
    				<div class="list-group" id="chatdiv">
    					<?php 
    					    $all_chats=$chatM->getAllChatWithUnviewedMessage($ins_id, $stud_id, TRUE);
    					    if (!is_null($all_chats)) {
    					        while ($row=$all_chats->fetch_assoc()) { ?>
 								 <a id="<?=$row['ChatId']?>"  href="#" class="list-group-item list-group-item-action chat_combo">
 								 <input type="hidden" id="ins<?=$row['ChatId']?>" value="<?=$row['InstructorId']?>">
 								 <input type="hidden" id="stud<?=$row['ChatId']?>" value="<?=$row['StudentId']?>">
                                	 <small>
                                	 	<?=$row['NAME']?> <span class="badge text-bg-danger <?=($row['Unviewed']==0?"d-none":"")?>"> <?=$row['Unviewed']?></span>
                                    </small>
                                    <br>
                                    <small class="text-secondary"><em><?=$row['TOPMSG']?></em></small>
    							 </a>
    					<?php   }
    					    }
    					?>    			
    				</div>
    			</div>
    		</div>
    		<div class="col-sm-12 col-md-6 col-lg-8 " >
    			<div class="border flex-nowrap  overflow-auto p-2" style="height: 500px;" >  
    				<div class="row text-center p-2">
    					<div class="col-md-10">
    						<textarea id="msg_txt" class="form-control " placeholder="Message" rows="2" cols="" disabled></textarea>
    					</div>
    					<div class="col-md-2">
    						<button id="send_btn"  class="btn btn-primary btn-sm" disabled>Send</button>
    						<a  id="videocall_btn"  class="btn btn-primary  btn-sm mt-1 disabled" aria-disabled="true" tabindex="-1">Video Call</a>
    					</div>
    				</div>
    				<ol class="list-group " id="msgdiv">
    				
                    </ol>
    			</div>
    		</div>
    	</div>
    </div>
<?php 
require_once("views/footer.php");    
?>
<script>
$(function(){

	var insid=0;
	var studid=0;
	var sender_insid=<?=$ins_id?>;
	var sender_studid=<?=$stud_id?>;
		   		
	$(document).on("click", ".chat_combo", function(){
		$(".chat_combo").removeClass("active");
		$(this).addClass("active");
		
		var chat_id=$(this).attr('id');
		
		$.ajax({
	    url: 'api/GetAllMessageOfChat.php',
	    method: 'GET',
	    data: {
	      chat_id: chat_id,
	    },
	    success: function(response) {
	     	 //console.log(response);
		     	$('#msgdiv').html("");
	      $.each(response, function(index, value) {
		      
		      var is_ins=<?=($_SESSION["RoleSEPTS"] == "Instructor"?1:0)?>;
		      var float_msg="";
		      var msg_name=(value.INSNAME!=null)?value.INSNAME:value.STUDNAME;
		     	
		     	if(is_ins && value.SenderIns!=null){
		     		float_msg="float-end";
		     		msg_name="You";
		     	}
		     	
		     	if(!is_ins && value.SenderStudent!=null){
		     		float_msg="float-end";
		     		msg_name="You";
		     	}
		     	
		     	var msg=value.Message;
		     	if(msg.startsWith("meeting ID:")){
		     		var metid=msg.substring(11);
		     		msg="<a href='VideoCallJoin.php?m="+metid+"'>JOIN VIDEO CALL...</a>"
		     	}
		     	
		      	$('#msgdiv').append(
                '<li class="list-group-item  justify-content-between align-items-start">'+
                        '<div class="ms-2 me-auto '+float_msg+'">'+
                          '<div class="fw-bold ">'+msg_name+'</div>'+
                          '<em>'+msg+'</em>'+
                        '</div>'+
                      '</li>');
		   });
		   
		   		insid=$("#ins"+chat_id).val();
		   		studid=$("#stud"+chat_id).val();
                $("#msg_txt").attr("disabled", null );                
                $("#send_btn").attr("disabled",  null);                  
                $("#videocall_btn").attr("aria-disabled",  false);                       
                $("#videocall_btn").removeClass("disabled");                           
                $("#videocall_btn").attr("tabindex", null);                              
                $("#videocall_btn").attr("href", "VideoCall.php?i="+insid+"&s="+studid);         
	
	      
	    },
	    error: function(xhr, status, error) {
	      console.log(error);
	    }
	  });
	});
	
	
	$("#send_btn").click(function(){
		
		var msg=$('#msg_txt').val();
		
		if(msg!=""){
		if(studid>0 && insid>0){
    		$('#msgdiv').prepend(
            '<li class="list-group-item  justify-content-between align-items-start">'+
                    '<div class="ms-2 me-auto float-end">'+
                      '<div class="fw-bold ">You</div>'+
                      '<em>'+msg+'</em>'+
                    '</div>'+
                  '</li>');
                  
                  $('#msg_txt').val("")
                  
                  addChat(insid, studid, sender_insid, sender_studid, msg);
             
           }else{
           		alert("Choose chat Combo");
           }   
        }
	});
	
	
	function addChat(instructorsId, studId, senderinsId, senderstudId, message){
		// Get the form data
		  var formData = {
		    instructorsId: instructorsId,
		    studId:studId,
		    senderstudId:senderstudId,
		    senderinsid:senderinsId,
		    msg:message,
		    meetingid:0
		  };
		
		  // Send the form data to the server using AJAX
		  $.ajax({
		    type: 'POST',
		    url: 'api/ChatAdd.php', // Replace with the URL of your server-side script
		    data: formData,
		    success: function(response) {
		      // Handle the response from the server
		      console.log(response);
		    },
			  error: function(xhr, status, error) {
			    // Handle any errors that occur during the request
			    console.log(error);
			    alert(error);
			  }
		  });
	}
	
});
</script>