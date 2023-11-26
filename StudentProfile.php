<?php
    session_start();
    
    if (!isset($_SESSION["loggedinSEPTS"])) {
        header("location: login.php");
        exit();
    }
    
    
    if (!isset($_SESSION["RoleSEPTS"]) || $_SESSION["RoleSEPTS"] != "Student") {
        header("location: 404.php");
        exit();
    }
   
    require_once ('model/StudentModel.php');
    $stud=new StudentModel();
    
    
    require_once ('model/UserModel.php');
    $us= new UserModel();
    
    
    
    require_once ('model/SectionModel.php');
    $sec= new SectionModel();
    
    
    
    require_once 'model/FileUploadModel.php';
    $upload=new FileUploadModel();
    
    
    
    
    require_once("views/header.php");
    require_once("views/navi.php");

if ($stud->isRequestPost()) {
    $id=$stud->escapeString($_POST['Id']);
    
    if (isset($_POST['formInfo'])) {
        
        $resultEdit=$stud->EditStudent
        ($id, 
            $stud->escapeString($_POST['idno']), 
            $stud->escapeString($_POST['fname']), 
            $stud->escapeString($_POST['mname']), 
            $stud->escapeString($_POST['lname']), 
            $stud->escapeString($_POST['xname']), 
            $stud->escapeString($_POST['gender']), 
            $stud->escapeString($_POST['contact']));
        
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
        
        $idins=$_SESSION["StudentId"];
        $image="";
        if (!is_null($_FILES['file-input-photo']["name"]) && $_FILES['file-input-photo']["name"]!=="") {
            
            $image=$upload->UploadFile('file-input-photo', "img/stud/",$_SESSION["StudentId"]);
        }
        
        $stud->EditPhoto($idins, $image);
    }
    
    elseif (isset($_POST['formClass'])) {
        
        $idstud=$_SESSION["StudentId"];
        $classId=$stud->escapeString($_POST['sec']);
        $syid=$sec->getTopSY()['SYCode'];
        
        if($sec->addEditStudSec($idstud, $classId, $syid)){
            $_SESSION["StudentClassSection"]=$classId;
        }
    }
}

$studO=$stud->getStudent($_SESSION["StudentId"]);
$syid=$sec->getTopSY()['SYCode'];



?>
<div class="container d-flex justify-content-center">
    <div class=" row">
    
    <div class="col-md-4 ">
      <div class="card shadow m-2 p-2">
    	<h4 class="text-center">PROFILE INFO</h4>
    	<form method="post"  id="formInfo" class="row g-1">
    	<input type="hidden" name="Id" value="<?=$studO['StudentId']?>">
          <div class="col-md-12 ">
            <label for="idno" class="form-label">Student ID No*:</label>
            <input value="<?=$studO['StudentIDNo']?>" type="text" class="form-control" id="idno" name="idno" required>
          </div>
          <div class="col-md-12 ">
            <label for="fname" class="form-label">Firstname*:</label>
            <input value="<?=$studO['Firstname']?>" type="text" class="form-control" id="fname" name="fname" required>
          </div>
          <div class="col-md-12 ">
            <label for="mname" class="form-label">Middle name</label>
            <input value="<?=$studO['Middlename']?>" type="text" class="form-control" id="mname" name="mname" >
          </div>
           <div class="col-md-12 ">
            <label for="lname" class="form-label">Lastname*:</label>
            <input value="<?=$studO['Lastname']?>" type="text" class="form-control" id="lname" name="lname" required>
          </div>
          <div class="col-md-12 ">
            <label for="xname" class="form-label">Name Ext.</label>
            <input value="<?=$studO['NameExt']?>" type="text" class="form-control" id="xname" name="xname">
          </div>
          <div class="col-md-12 ">
            <label for="gender" class="form-label">Gender*:</label>
            <select id="gender" name="gender" class="form-select" required>
              <option selected value="">Choose...</option>
              <option <?=($studO['Gender']=='Male'?'selected="selected"':'')?>  value="Male">Male</option>
              <option <?=($studO['Gender']=='Female'?'selected="selected"':'')?> value="Female">Female</option>
            </select>
          </div> 
          <div class="col-md-12 ">
            <label for="contact" class="form-label">Contact Number*:</label>
            <input value="<?=$studO['ContactNumber']?>" type="tel" class="form-control" id="contact" name="contact" required>
          </div> 
          
        	<div class="d-grid gap-2 mt-2">
            	<button name="formInfo" type="submit" class="btn btn-primary">Save Profile</button>
          	</div>  
          	</form>
          	</div>
     </div>
     
    <div class="col-md-8 ">
      
      <div class="col-md-12 ">
          <div class="card shadow m-2 p-2">    
        	<strong class="text-center">Register on Class Section</strong>
        	<form method="post" enctype="multipart/form-data" class="row g-2">
        	<input type="hidden" name="Id" value="<?=$studO['StudentId']?>">
              <div class="col-md-12 ">    
                <select name="sec" class="form-select" required>
                	<option value="">Choose Class Section--</option>
                	<?php 
                	    $classData=$sec->getAllActive();
                	    if (!is_null($classData)) {
                	        while ($row=$classData->fetch_assoc()) {
            	            ?> 
            				<option <?=($sec->getStudSec($_SESSION["StudentId"], $syid)!=0&&$sec->getStudSec($_SESSION["StudentId"], $syid)["SectionId"]==$row['SectionId']?"selected":"");?> value="<?=$row['SectionId'];?>"><?=$row['Section'];?></option>         
            	            <?php 
                	        }
                	    }
                	?>
                </select> 
              </div>              
                <div class="d-grid gap-2 mb-1">
                	<button name="formClass" type="submit" class="btn btn-primary">Register</button>
                </div>
         	</form>  
          </div>
      </div>
      
      <div class="row">      
        <div class="col-md-6 ">
          <div class="card shadow m-2 p-2">    
        	<h5 class="text-center">SECURITY PROFILE</h5>
        	<form method="post"  class="row g-1">
        	<input type="hidden" name="Id" value="<?=$studO['StudentId']?>">
        	<input type="hidden" id="email" name="email" value="<?=$studO['Email']?>">
               <div class="col-md-12 ">
                <label for="email" class="form-label">Email*:</label>
                <input value="<?=$studO['Email']?>" type="email" class="form-control"  disabled>
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
                <div class="d-grid gap-2 mb-1">
                	<button name="formPW" type="submit" class="btn btn-primary">Save New Password</button>
                </div>
         	</form>  
          </div>  
          </div> 
          
          <div class="col-md-6 ">
          <div class="card shadow m-2 p-2">    
        	<h5 class="text-center">PROFILE PHOTO</h5>
        	<form method="post" enctype="multipart/form-data" class="row g-2">
        	<input type="hidden" name="Id" value="<?=$studO['Image']?>">
        	<div class="text-center">
              <img width="230" height="200" id="preview" src="<?=$studO['Image']==''?'img/undraw_profile.svg':$studO['Image']; ?>" class="rounded responsive" alt="...">
            </div>       
              <div class="col-md-12 ">
                <label for="Password2" class="form-label">Upload Photo:</label>
                <input type="file" id="file-input" class="form-control" name="file-input-photo" required>
                <small class="form-text text-muted">
                	File type(jpg/.jpeg/.png) less than 5MB
               </small>
              </div>      
                <div class="d-grid gap-2 mb-1">
                	<button name="formPhoto" type="submit" class="btn btn-primary">Save Photo</button>
                </div>
         	</form>  
          </div>  
          </div> 
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