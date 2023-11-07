<?php 
session_start();

if (isset($_SESSION["loggedinSEPTS"])) {
    header("location: index.php");
    exit();
}

require_once ('model/InstructorModel.php');
$ins=new InstructorModel();

require_once ('model/UserModel.php');
$use=new UserModel();

require_once ('model/StudentModel.php');
$stud=new StudentModel();

require_once("views/header.php");
require_once("views/navi.php");


?>
<div class="container d-flex justify-content-center">
<div class="w-50">
<h2 class="text-center">REGISTRATION</h2>
<?php 
if ($ins->isRequestPost()) {
    $pw1=$ins->escapeString($_POST['Password1']);
    $pw2=$ins->escapeString($_POST['Password2']);
    $cap=$ins->escapeString($_POST['captcha']);
    
    
    if ($pw1==$pw2) {
        if ($cap==$_SESSION['captcha']) {
            
            $ASRadio=$ins->escapeString($_POST['AsRadio']);
            if ($ASRadio==8) {
                
               $id= $ins->Add(
                    $ins->escapeString($_POST['fname']),
                    $ins->escapeString($_POST['mname']),
                    $ins->escapeString($_POST['lname']),
                    $ins->escapeString($_POST['xname']),
                    $ins->escapeString($_POST['gender']),
                    $ins->escapeString($_POST['contact']),
                    $ins->escapeString($_POST['email']),
                   "active",
                   $ins->escapeString($_POST['idno']),);
               
               if ($id>0) {
                   $use->AddEmpUser($id, $ins->escapeString($_POST['email']), 8, $pw2);
               }
                
            }else {
                $id=$stud->addStudent(
                    $ins->escapeString($_POST['idno']),
                    $ins->escapeString($_POST['fname']),
                    $ins->escapeString($_POST['mname']),
                    $ins->escapeString($_POST['lname']),
                    $ins->escapeString($_POST['xname']),
                    $ins->escapeString($_POST['email']),
                    $ins->escapeString($_POST['contact']),
                    $ins->escapeString($_POST['gender']));                
                
                if ($id>0) {
                    $use->AddStudentUser($id, "active", $pw2, $ins->escapeString($_POST['email']));
                }
            }
            
            echo "<div class='alert alert-success'>Successfully Registered!</div>";
        
    }else {
        echo "<div class='alert alert-danger'>Invalid captcha!</div>";
    }
}else {
    echo "<div class='alert alert-danger'>Password not the same!</div>";
}
}

?>
<form method="post" class="row g-3">
  <div class="col-md-6">
  <div class="col-md-12 mb-2">
    <label for="idno" class="form-label">Instructor/Student ID No*:</label>
    <input type="text" class="form-control" id="idno" name="idno" required>
  </div>
  <div class="col-md-12 mb-2">
    <label for="fname" class="form-label">Firstname*:</label>
    <input type="text" class="form-control" id="fname" name="fname" required>
  </div>
  <div class="col-md-12 mb-2">
    <label for="mname" class="form-label">Middle name</label>
    <input type="text" class="form-control" id="mname" name="mname" >
  </div>
   <div class="col-md-12 mb-2">
    <label for="lname" class="form-label">Lastname*:</label>
    <input type="text" class="form-control" id="lname" name="lname" required>
  </div>
  <div class="col-md-12 mb-2">
    <label for="xname" class="form-label">Name Ext.</label>
    <input type="text" class="form-control" id="xname" name="xname">
  </div>
  <div class="col-md-12 mb-3">
    <label for="gender" class="form-label">Gender*:</label>
    <select id="gender" name="gender" class="form-select" required>
      <option selected value="">Choose...</option required>
      <option value="Male">Male</option required>
      <option value="Female">Female</option required>
    </select>
  </div> 
  <span class="text-center  d-none d-lg-block">Already have an account? Login <a href="login.php">here</a></span>  
   </div>

   
  <div class="col-md-6 mb-2">
  <div class="col-md-12 mb-2">
    <label for="contact" class="form-label">Contact Number*:</label>
    <input type="tel" class="form-control" id="contact" name="contact" required>
  </div>  
  <div class="col-md-12 mb-2">
    <label for="gender" class="form-label">Register as*:</label><br>
    <div class="text-center">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="AsRadio" id="inlineRadio1" value="8" required>
      <label class="form-check-label" for="inlineRadio1">Instructor</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="AsRadio" id="inlineRadio2" value="9" required>
      <label class="form-check-label" for="inlineRadio2">Student</label>
    </div></div>
  </div>
   <div class="col-md-12 mb-2">
    <label for="email" class="form-label">Email*:</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="col-md-12 mb-2">
    <label for="Password1" class="form-label">Password*:</label>
    <input type="password" class="form-control" id="Password1" name="Password1" required>
  </div>
  <div class="col-md-12 mb-2">
    <label for="Password2" class="form-label">Confirm Password*:</label>
    <input type="password" class="form-control" id="Password2" name="Password2" required>
  </div>
  <?php 
$ins->generateCaptchaStringToSession(7);
?>
 <div class="col-md-12 mb-2 text-center">
    <img width="130" src="model/Captcha.php">
  </div>
 <div class="col-md-12 mb-4">
    <input placeholder="Enter Captcha challenge" type="text" class="form-control" id="captcha" name="captcha" required>
  </div>
<div class="d-grid gap-2 mb-5">
    <button type="submit" class="btn btn-primary">Register</button>
  </div>
  
  <span class="text-center d-sm-block d-md-none">Already have an account? Login <a href="login.php">here</a></span>
  
  </div>
 </form>
</div>
</div>
<?php 
require_once("views/footer.php");    
?>