<?php
    session_start();
    
    if (!isset($_SESSION["loggedinSEPTS"])) {
        header("location: login.php");
        exit();
    }
    require_once ('model/InstructorModel.php');
    $ins=new InstructorModel();
    
    if (isset($_GET['id']) && $_GET['id']!="") {
        $ins->Verify($ins->escapeString($_GET['id']));
    }
    
    header("location: UserManagment.php?u=i&m=Instructor Successfully verified!");
    exit();


?>