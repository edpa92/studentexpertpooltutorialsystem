<?php
session_start();

if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}

if (!isset($_SESSION["RoleSEPTS"])) {
    header("location: 404.php");
    exit();
}

require_once(dirname(__DIR__) ."/model/ChatModel.php");
$chatM= new ChatModel();

if (!$chatM->isRequestPost()) {
    
    try {
        
        $chat_Id=$chatM->escapeString($_GET['chat_id']);        
        $msgs=$chatM->getAllMessagesOfChat($chat_Id);
        
       
        
        $rows = array();
        while ($row = $msgs->fetch_assoc()) {
            $rows[] = $row;
        }
        
         $_SESSION["unread_msg"]=0;
         if ($_SESSION["RoleSEPTS"]=="Student") {
            $chatM->markAllMessagesOfChatViewed($chat_Id,1,0);
        }elseif ($_SESSION["RoleSEPTS"]=="Instructor") {
            $chatM->markAllMessagesOfChatViewed($chat_Id,0,1);
        }
        
        // Set the appropriate headers for JSON response
        header('Content-Type: application/json');
        echo json_encode($rows);
    }
    
    catch (Exception $e) {
        $responseData = array('ERROR' => $e);
        
        echo json_encode($responseData);
    }
}

?>