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
    
    require_once ('model/InstructorModel.php');
    $insO=new InstructorModel();
    
    require_once ('model/SectionModel.php');
    $secO=new SectionModel();
    
    
    if ($secO->isRequestPost()) {
        if (isset($_POST['flexSwitchSec']) && count($_POST['flexSwitchSec'])>0) {
            for ($i = 0; $i < count($_POST['flexSwitchSec']); $i++) {

                if (!is_null($_POST['flexSwitchSec'][$i])) {                   
                    $insO->addInsLoad($_SESSION["EmpIdSEPTS"], $_POST['flexSwitchSec'][$i]);
                }
            }           
        }
        
        header("location: InstructorLoad.php");
        exit();
    }


require_once("views/header.php");
require_once("views/navi.php");
?>
<div class="container">
   	<h4>Choose Class section(s) to add as your Load</h4>
   	<form action="" method="post">
   	<?php 
   	    $sec=$secO->getAllActiveNotLoad($_SESSION["EmpIdSEPTS"]);
   	    if (!is_null($sec)) {
   	        while ($row=$sec->fetch_assoc()) {
   	            ?>
   	        <h5 class="form-check form-switch">
              <input class="form-check-input" value="<?=$row['SectionId'];?>" type="checkbox" role="switch" id="flexSwitchSec" name="flexSwitchSec[]" >
              <label class="form-check-label" for="flexSwitchSec"><?=$row['Section'];?></label>
            </h5>
   	    <?php }
   	    }
   	?>
   	<input type="submit" class="mt-3 btn btn-primary " value="Add as Load">
   	</form>
</div>
<?php 
require_once("views/footer.php");    
?>