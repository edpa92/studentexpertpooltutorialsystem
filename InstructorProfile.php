<?php
    session_start();
    
    if (!isset($_SESSION["loggedinSEPTS"])) {
        header("location: login.php");
        exit();
    }
    
    
    if (!isset($_SESSION["RoleSEPTS"]) || $_SESSION["RoleSEPTS"] != "Instructor") {
        header("location: 404.php");
    }
    
    require_once ('model/InstructorModel.php');
    $stud=new InstructorModel();
    
    
    require_once ('model/UserModel.php');
    $us= new UserModel();
    
    
    require_once 'model/FileUploadModel.php';
    $upload=new FileUploadModel();
    
    
    require_once("views/header.php");
    require_once("views/navi.php");
    
    if ($stud->isRequestPost()) {  
        $id=$stud->escapeString($_POST['Id']);
        
        if (isset($_POST['formInfo'])) {
            
            $resultEdit=$stud->EditInfo($id,
                $stud->escapeString($_POST['fname']), 
                $stud->escapeString($_POST['mname']), 
                $stud->escapeString($_POST['lname']), 
                $stud->escapeString($_POST['xname']), 
                $stud->escapeString($_POST['gender']), 
                $stud->escapeString($_POST['contact']), 
                $stud->escapeString($_POST['idno']));
            if ($resultEdit) {                
                echo "<div class='alert alert-success m-3'>Info Updated!</div>";
            }
        }
        
        elseif (isset($_POST['formPW'])) {
            $userCheck=$us->check_user($_POST['email'], $_POST['Password']);
           if ($userCheck) {
               $pw=$us->escapeString($_POST['Password']);
               $pw1=$us->escapeString($_POST['Password1']);
               $pw2=$us->escapeString($_POST['Password2']);
               $un=$us->escapeString($_POST['email']);
              
               if ($pw1!=$pw2) {
                   echo "<div class='alert alert-danger m-3'>The Passwords not the same!</div>";
               }else{
                   $msg=$us->ChangePW($_SESSION["UserIdSEPTS"], $un, $pw, $pw1, $pw2);
                   
                   echo "<div class='alert alert-success m-3'>$msg</div>";
               }
               
           }else {               
               echo "<div class='alert alert-danger m-3'>Invalid Username/Password!</div>";
               
           }
        }
        
        elseif (isset($_POST['formPhoto'])) {
            
            $idins=$stud->escapeString($_POST['Id']);
            $image="";
            if (!is_null($_FILES['file-input-photo']["name"]) && $_FILES['file-input-photo']["name"]!=="") {
                
                $image=$upload->UploadFile('file-input-photo', "img/ins/",$_SESSION["EmpIdCodeSEPTS"]);
            }
            
            $stud->EditPhoto($idins, $image);
        }
    }
    
    $insO=$stud->getInstructor($_SESSION["EmpIdCSHS"]);
    
    ?>
<div class="container d-flex justify-content-center">
<div class=" row">

  <div class="col-md-4 ">
  <div class="card shadow m-2 p-2">
<h4 class="text-center">PROFILE INFO</h4>
	<form method="post"  id="formInfo" class="row g-1">
	<input type="hidden" name="Id" value="<?=$insO['EmpKey']?>">
      <div class="col-md-12 ">
        <label for="idno" class="form-label">InstructorID No*:</label>
        <input value="<?=$insO['EmpId']?>" type="text" class="form-control" id="idno" name="idno" required>
      </div>
      <div class="col-md-12 ">
        <label for="fname" class="form-label">Firstname*:</label>
        <input value="<?=$insO['Firstname']?>" type="text" class="form-control" id="fname" name="fname" required>
      </div>
      <div class="col-md-12 ">
        <label for="mname" class="form-label">Middle name</label>
        <input value="<?=$insO['MI']?>" type="text" class="form-control" id="mname" name="mname" >
      </div>
       <div class="col-md-12 ">
        <label for="lname" class="form-label">Lastname*:</label>
        <input value="<?=$insO['Lastname']?>" type="text" class="form-control" id="lname" name="lname" required>
      </div>
      <div class="col-md-12 ">
        <label for="xname" class="form-label">Name Ext.</label>
        <input value="<?=$insO['NameExt']?>" type="text" class="form-control" id="xname" name="xname">
      </div>
      <div class="col-md-12 ">
        <label for="gender" class="form-label">Gender*:</label>
        <select id="gender" name="gender" class="form-select" required>
          <option selected value="">Choose...</option>
          <option <?=($insO['Gender']=='Male'?'selected="selected"':'')?>  value="Male">Male</option>
          <option <?=($insO['Gender']=='Female'?'selected="selected"':'')?> value="Female">Female</option>
        </select>
      </div> 
      <div class="col-md-12 ">
        <label for="contact" class="form-label">Contact Number*:</label>
        <input value="<?=$insO['Contact']?>" type="tel" class="form-control" id="contact" name="contact" required>
      </div> 
      
    	<div class="d-grid gap-2 mt-2">
        	<button name="formInfo" type="submit" class="btn btn-primary">Save Profile</button>
      	</div>  
      	</form>
      	</div>
 </div>

   
  <div class="col-md-4 ">
  <div class="card shadow m-2 p-2">    
	<h4 class="text-center">SECURITY PROFILE</h4>
	<form method="post"  class="row g-1">
	<input type="hidden" name="Id" value="<?=$insO['EmpKey']?>">
	<input type="hidden" id="email" name="email" value="<?=$insO['Email']?>">
       <div class="col-md-12 ">
        <label for="email" class="form-label">Email*:</label>
        <input value="<?=$insO['Email']?>" type="email" class="form-control"  disabled>
      </div>
      <div class="col-md-12 ">
        <label for="Password" class="form-label">Password*:</label>
        <input type="password" class="form-control" id="Password" name="Password" required>
      </div>
      <div class="col-md-12 ">
        <label for="Password1" class="form-label">New Password*:</label>
        <input type="password" class="form-control" id="Password1" name="Password1" required>
      </div>
      <div class="col-md-12 ">
        <label for="Password2" class="form-label">Confirm New Password*:</label>
        <input type="password" class="form-control" id="Password2" name="Password2" required>
      </div>
    
        <div class="d-grid gap-2 mb-5">
        	<button name="formPW" type="submit" class="btn btn-primary">Save New Password</button>
        </div>
 	</form>  
  </div>  
  </div> 
  
  <div class="col-md-4 ">
  <div class="card shadow m-2 p-2">    
	<h4 class="text-center">PROFILE PHOTO</h4>
	<form method="post" enctype="multipart/form-data" class="row g-2">
	<input type="hidden" name="Id" value="<?=$insO['EmpKey']?>">
	<div class="text-center">
      <img width="230" height="200" id="preview" src="<?=$insO['Photo']==''?'img/undraw_profile.svg':$insO['Photo']; ?>" class="rounded responsive" alt="...">
    </div>
       
      <div class="col-md-12 ">
        <label for="Password2" class="form-label">Upload Photo:</label>
        <input type="file" id="file-input" class="form-control" name="file-input-photo" required>
        <small class="form-text text-muted">
        	File type(jpg/.jpeg/.png) less than 5MB
       </small>
      </div>
      
        <div class="d-grid gap-2 mb-5">
        	<button name="formPhoto" type="submit" class="btn btn-primary">Save Photo</button>
        </div>
 	</form>  
  </div>  
  </div> 
  
   
</div>
</div>
<?php 
require_once("views/footer.php");    
?>


<script>
$(document).ready(function(){

  // When the file input changes
  $('#file-input').change(function(){
    
    // Get the selected file
    var file = this.files[0];
    
    
    if (!file.type.match('image.*')) {
      alert('Please select an image file.');
      this.value="";
      return;
    }
    
    if (file.size > 1024 * 1024*5) {
      alert('File size should not exceed 1MB.');
      this.value="";
      return;
    }

    // Create a file reader object
    var reader = new FileReader();

    // Set up the file reader onload function
    reader.onload = function(e){
      // Set the preview image source to the data URL of the loaded image
      $('#preview').attr('src', e.target.result);
    }

    // Read the file as a data URL
    reader.readAsDataURL(file);
  });
  
  $('#file-input').click(function(){
  	$('#preview').attr('src', "img/cshs_seal.jpg" );
  })
  
});

</script>