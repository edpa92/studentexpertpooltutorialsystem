<?php
    session_start();
    
    if (!isset($_SESSION["loggedinSEPTS"])) {
        header("location: login.php");
        exit();
    }
    require_once ('model/InstructorModel.php');
    $stud=new InstructorModel();
    
    if (isset($_GET['id']) && $_GET['id']!="") {
        $stud->Verify($stud->escapeString($_GET['id']));
    }
    
    header("location: UserManagment.php?u=i&m=Instructor Successfully verified!");
    exit();


?>