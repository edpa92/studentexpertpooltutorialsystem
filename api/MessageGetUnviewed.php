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
        
        if (isset($_SESSION["RoleSEPTS"])&& $_SESSION["RoleSEPTS"]=="Student") {
            $unviewed=$chatM->getAllChatWithUnviewedMessage(0,$Id, FALSE);
        }elseif (isset($_SESSION["RoleSEPTS"])&&$_SESSION["RoleSEPTS"]=="Instructor") {
            $unviewed=$chatM->getAllChatWithUnviewedMessage($Id,0, FALSE);
        }
       
        $rows = array();
        if (!is_null($unviewed)) {
            
            while ($row = $unviewed->fetch_assoc()) {
                $rows[] = $row;
            }
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