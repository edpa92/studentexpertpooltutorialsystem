<?php
session_start();

if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}

    require_once 'model/SubjectModel.php';
    $subO=new SubjectModel();
    
    require_once 'model/MaterialsModel.php';
    $matO=new MaterialsModel();

require_once("views/header.php");
require_once("views/navi.php");
?>

 <div class="container">
	<?php 
	if (isset($_SESSION["RoleSEPTS"]) && $_SESSION["RoleSEPTS"] == "Student") {
	    
	    if (isset($_SESSION["StudentClassSection"])&&$_SESSION["StudentClassSection"]>0) {
	    $subStud=$subO->getAllActiveSubjectOfStudent($_SESSION["StudentClassSection"]);
	    
	    if (!is_null($subStud)) {
	       while ($row=$subStud->fetch_assoc()) {
	           ?>
	    <div class="card mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?=($row['Subject'])?> <small class="text-primary-emphasis float-end">Learning materials</small></h6>
            </div>
            <div class="card-body px-3 row flex-nowrap overflow-auto">
    	  		<?php 
    	  		    $mat=$matO->getAllMaterialsBySubjectforSection($row['SubjectCode'], $_SESSION["StudentClassSection"]);
    	  		    if (!is_null($mat)) {
    	  		        while ($rowM=$mat->fetch_assoc()) { if($rowM['Status']==1) {
    	  		            ?>    	  		               	  		             
                    <div class="card mx-2" style="width: 18rem;">
                      <div class="card-body">
                        <h5 class="card-title"><?=($rowM['Title']);?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?=($rowM['TopicDescription']);?></h6>
                        
							<?php 
							if ($rowM['CategoryName']=="Videos") {?>
    							<h1 class=" border text-center py-5">
    								<i class="bi bi-play-circle-fill"></i>
    								<small>Video</small>
    							</h1>
							<?php }else if ($rowM['CategoryName']=="Docs/Sheets/Slides/PDF") {
							?>
								<h1 class=" border text-center py-5">
    								<i class="bi bi-file-text-fill"></i>
    								<small>Files</small>
    							</h1>
							<?php }else if ($rowM['CategoryName']=="Sites") {
							?>
								<h1 class=" border text-center py-5">
    								<i class="bi bi-globe2"></i>
    								<small>Website</small>
    							</h1>
							<?php }else if ($rowM['CategoryName']=="Images") {
							?>
								<h1 class=" border text-center py-5">
    								<i class="bi bi-images"></i>
    								<small>Image</small>
    							</h1>
							<?php }else if ($rowM['CategoryName']=="Google Drive Folder/File") {
							?>
								<h1 class=" border text-center py-5">
    								<i class="bi bi-folder2"></i>
    								<small>G-Drive Folder/Files</small>
    							</h1>
							<?php } ?>
							

						<a target="_blank" class='btn btn-outline-primary btn-sm p-auto' href="LearningMaterialsDetails.php?id=<?=($rowM['MaterialNo']);?>" class="card-link float-end">View</a>
						<small style="font-size: 10px;" class="text-secondary float-end">Posted by:<?=($rowM['Firstname']." ".$rowM['MI']." ".$rowM['Lastname']." ".$rowM['NameExt'])?></small>
						
                      </div>
                    </div>
              <?php  } }
    	  		    }else {    	  		        
    	  		        echo "<h4>No learning Materials Uploaded for this Subject.</h4>";
    	  		    }
    	  		?>       
            </div>
         </div>
	    
	      <?php }
	    }
	 }else {
   ?>
	  <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
	  		<h4 class="text-center">You did not register yet in a class section, Registere <a href="StudentProfile.php">here</a></h4>
        </div>
    </div>
	   <?php
        }
	}	
    ?>
 
 </div>
<?php 
require_once("views/footer.php");    
?>