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

require_once(dirname(__DIR__) ."/model/ChatModel.php");
    $chatM= new ChatModel();

  
    
    
if ($chatM->isRequestPost()) {
    
    try {
        
   
    $instructorsId=$chatM->escapeString($_POST['instructorsId']);    
    $studId=$chatM->escapeString($_POST['studId']);
    
    $senderstudId=$chatM->escapeString($_POST['senderstudId']);
    $senderinsid=$chatM->escapeString($_POST['senderinsid']);
    
    $meetingid=$chatM->escapeString($_POST['meetingid']);
    
    $msg=$chatM->escapeString($_POST['msg']);
    
    $chatid=0;
    
    
    $chat=$chatM->isChatExisted($instructorsId, $studId);
    
    if (!is_null($chat)) {
        $chatid=$chat['ChatId'];
    }else {
        $chatid=$chatM->addChat($studId, $instructorsId, $chatM->getCurrentDate(),$meetingid);
    }
    
    $ismsgadded=$chatM->addMessage($chatid, $senderstudId, $senderinsid, $chatM->getCurrentDate(), $msg);
   
    $responseData = array('IsMsgAdded' => $ismsgadded, 'chatid'=>$chatid,'senderstudId'=>$senderstudId,'$senderinsid'=>$senderinsid,'date'=>$chatM->getCurrentDate(),'msg'=>$msg);
    // Set the appropriate headers for JSON response
    header('Content-Type: application/json');
    echo json_encode($responseData);
    } 
    
    catch (Exception $e) {
        $responseData = array('ERROR' => $e);
        
        echo json_encode($responseData);
    }
}

?>