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
        
        $Id=$chatM->escapeString($_GET['id']);
        $unviewed=NULL;
        
        if ($_SESSION["RoleSEPTS"]=="Student") {
            $unviewed=$chatM->countAllUnviewedMessage(0,$Id);
           
        }elseif ($_SESSION["RoleSEPTS"]=="Instructor") {
            $unviewed=$chatM->countAllUnviewedMessage($Id,0);
            
        }
        
        
        $count=is_null($unviewed)?0:$unviewed['Unviewed'];
        $_SESSION["unread_msg"]=$count;
        
        $responseData = array("unviewed"=>$count);
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