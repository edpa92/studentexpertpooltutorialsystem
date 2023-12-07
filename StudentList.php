<?php
session_start();
if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}


if (!isset($_SESSION["RoleSEPTS"]) || $_SESSION["RoleSEPTS"] != "Instructor") {
    header("location: 404.php");
    exit();
}


require_once ('model/SectionModel.php');
$secM=new SectionModel();

require_once ('model/StudentModel.php');
$studM=new StudentModel();
$stud_list=null;

if (isset($_GET['secid'])&&$_GET['secid']!=""){
    $id=$studM->escapeString($_GET['secid']);
    $sec=$secM->get($id);
    $stud_list=$studM->getAllStudentsPerSec($id);
    
    if (is_null($sec)) {
        
        header("location: 404.php");
        exit();
    }
}else {
    
    header("location: 404.php");
    exit();
}


require_once("views/header.php");
require_once("views/navi.php");

?>
    <div class="container">
    	<h4><?=($sec['Section']);?> Class Sections Load : Student List</h4>   
    	<table id='fancyTableStud' class="table table-responsive table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Id#</th>
                      <th scope="col">Student Fullname </th>
                      <th scope="col">Email</th>
                      <th scope="col">Contact</th>
                      <th scope="col">Dat Registred</th>
                      <th scope="col">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php    
                  if(!is_null($stud_list)){
          while ($row=$stud_list->fetch_assoc()) { ?>   
                    <tr>
                      <td scope="row"><?=$row['StudentIDNo']?></td>
                      <td><?=$row['Firstname']?> <?=$row['Middlename']?> <?=$row['Lastname']?> <?=$row['NameExt']?></td>
                      <td><?=$row['Email']?></td>
                      <td><?=$row['ContactNumber']?></td>
                      <td><?=$row['DateRegistered']?></td>
                      <td><?=($row['EmailVerified']==0?"Unverified":"Verified")?></td>
                    </tr>
                    <?php  }
                  } ?>
                  </tbody>
                </table>      
        
    </div>
<?php 
require_once("views/footer.php");    
?>