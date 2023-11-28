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
    $ins=new InstructorModel();
    
    require_once("model/LessonModel.php");
    $les=new LessonModel();
    
    
    require_once("model/MaterialsModel.php");
    $mat=new MaterialsModel();

    $id=0;
    $matdata=NULL;
    if ($les->isRequestPost()) {
        
        $id=$les->escapeString($_POST["id"]);
        $isuploaded=false;
        
       
        $matId=$mat->addEdit($id, 
            $les->escapeString($_POST['lesson']), 
            $les->escapeString($_POST['materialname']), 
            $les->escapeString($_POST['description']), 
            $les->escapeString($_POST['url']), 
            $les->escapeString($_POST['category']), 
            $les->escapeString($_POST['status'])); 
                
        if (!is_null($_FILES['file']["name"]) && $_FILES['file']["name"]!=="") {
            $temp = explode(".", $_FILES['file']["name"]);
            $fileExt = end($temp);
            $target_file_path="materials/".($id>0?$id:$matId).".".$fileExt;
            
            $isuploaded=move_uploaded_file($_FILES['file']["tmp_name"], $target_file_path);
            if ($isuploaded) {
                $mat->EditMaterialFileUpladed(($id>0?$id:$matId), $target_file_path);
            }
            
            if ($id>0&&isset($_POST['materialfile'])&&$_POST['materialfile']!="") {
                unlink($les->escapeString($_POST['materialfile']));
            }
        }
        
        
        if ($id==0 && count($_POST['flexSwitchLoad'])>0) {
            for ($i = 0; $i < count($_POST['flexSwitchLoad']); $i++) {
                $mat->addMaterialLoad($mat->escapeString($_POST['flexSwitchLoad'][$i]), $matId);
            }            
            
        }elseif ($id>0 && count($_POST['flexSwitchLoad'])>0){
            
            $mat->deleteAllMatrialLoad($id);
            for ($i = 0; $i < count($_POST['flexSwitchLoad']); $i++) {
                $mat->addMaterialLoad($mat->escapeString($_POST['flexSwitchLoad'][$i]), $id);
            }
        }
        
        
        header("location: LearningMaterials.php");
        exit();
        
    }else {
        if (isset($_GET['id'])&&$_GET['id']!="") {
            $id=$les->escapeString($_GET['id']);
            $matdata=$mat->get($id);
            if (is_null($matdata)) {
                header("location: 404.php");
                exit();
            }
        }
    }


require_once("views/header.php");
require_once("views/navi.php");
?>
<div class="container">
<div class="row">
 <form method="post" class="row g-3" enctype="multipart/form-data">
	<div class="col-sm-12 col-md-8 col-lg-6">
    	<h2><?=($id>0?"Edit":"Add") ?> Learning Material</h2>
        	<?php 
        	    $load=$ins->getAllInsLoad($_SESSION["EmpIdSEPTS"]);
        	    if (is_null($load)) {?>		
        	<h4 >You don't have Class section load, Add load <a href="InstructorLoadAdd.php">here</a>.<br> before you can add Learning materials.</h4>
             
        	<?php }else {
        	?>
			<div class="row">
            <input type="hidden" name="id" value="<?=$id?>">
              <div class="col-md-6">
                <label for="lesson" class="form-label">Topic/Lesson*:</label>
                <select id="lesson" name="lesson" class="form-select" required="required">
                  <option value="" selected>Choose Topic/Lesson...</option>
                  <?php 
                  $dataLess=$les->getAllActive($_SESSION["EmpIdSEPTS"],0);
                  if (!is_null($dataLess)) {
                      while ($row=$dataLess->fetch_assoc()) {
                      ?>
                      	<option  <?=($id>0&&$matdata['TopicId']==$row["TopicNo"]?"selected":"");?> value="<?=$row["TopicNo"]; ?>" ><?="(".$row["Subject"].")".$row["TopicDescription"]; ?> </option>
                      <?php 
                          }
                      }
                  ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="category" class="form-label">Learning Materials Category*:</label>
                <select id="category" name="category" class="form-select" required="required">
                  <option  value="" selected>Choose Category...</option>
                  <?php 
                      $cat=$mat->getAllCatogory();
                      if (!is_null($cat)) {
                          while ($row=$cat->fetch_assoc()) {
                      ?>
                      	<option <?=($id>0&&$matdata['CategoryId']==$row["LMCatId"]?"selected":"");?> value="<?=$row["LMCatId"]; ?>" ><?=$row["CategoryName"]; ?> </option>
                      <?php 
                          }
                      }
                  ?>
                </select>
              </div>      
              <div class="col-md-6">
                <label for="materialname" class="form-label">Material Name*:</label>
                <input value="<?=($id>0?$matdata['Title']:""); ?>" type="text" class="form-control" id="materialname" name="materialname" required="required">
              </div>
              <div class="col-md-4">
                <label for="status" class="form-label">Status*:</label>
                <select id="status" name="status" class="form-select" required="required">
                  <option value="" selected>Choose...</option>
                  <option <?=($id>0&&$matdata['Status']==1?"selected":"");?> value="1" >Active</option>
                  <option <?=($id>0&&$matdata['Status']==0?"selected":"");?> value="0" >Inactive</option>
                </select>
              </div>
              <div class="col-12">
                <label for="description" class="form-label">Description*:</label>
                <textarea rows="5" cols="5" class="form-control" id="description"  name="description" required="required"><?=($id>0?$matdata['MaterialsDescription']:""); ?></textarea>
                
              </div>
              <div class="col-12">
                <label for="url" class="form-label">URL(Optional):</label>
                <input value="<?=($id>0?$matdata['URL']:""); ?>" type="text" class="form-control" id="url" name="url" placeholder="www.youtube.com" >
              </div>
              <div class="col-12">
                <label for="file" class="form-label">File(Optional):</label>
                <input  id="file-input" type="file" class="form-control" id="file"  name="file" >
                <input  id="materialfile" type="hidden" class="form-control" name="materialfile" value="<?=($id>0&&!is_null($matdata['Path'])?$matdata['Path']:"")?>">
                <small class="text-warning <?=($id>0&&$matdata['Path']!=""&&!is_null($matdata['URL'])?"":"d-none")?>">If you upload a new file, It will overwrite the current file of this Learning materials. Leave it blank if you don't want to change the file.</small>	
              </div>
    		</div>                
    	</div>    	
    	<div class="col-sm-12 col-md-4 col-lg-6 ps-xl-5 ps-lg-5 ps-sm-2">
    		<h4>Your Class section load(s)</h4>
    		<strong>This learning Material visible to:</strong>
    		<?php 
           	    if (!is_null($load)) {
           	        while ($row=$load->fetch_assoc()) {
           	            ?>
           	        <h5 class="form-check form-switch">
                      <input <?=($id>0&&$mat->isMaterialVisibleto($id, $row['LoadId'])?"checked":"");?> class="form-check-input loadcheckbox" value="<?=$row['LoadId'];?>" type="checkbox" role="switch" id="flexSwitchLoad" name="flexSwitchLoad[]">
                      <label class="form-check-label" for="flexSwitchLoad"><?=$row['Section'];?></label>
                    </h5>
           	    
           	    
           	    <?php }
           	    }
           	?>
    	</div>
    	<div class="col-12">
            <a href="LearningMaterials.php" class="btn btn-secondary">Back</a>
            <button type="submit" class="btn btn-primary savemtr">Save</button>
        </div>
    	
  </form>
        <?php }?>
   </div>
</div>
<?php 
require_once("views/footer.php");    
?>

<script type="text/javascript">
$(document).ready(function () {
    $('.savemtr').click(function() {
        checked = $("input[type=checkbox]:checked").length;

        if(!checked) {
            alert("You must check at least one of your Section Load.");
            return false;
        }
    });
    
    
    
    
    // When the file input changes
  $('#file-input').change(function(){
    
    // Get the selected file
    var file = this.files[0];
    var allowedTypes = /^image\/(jpeg|png|gif)|video\/(mp4|mov)|application\/(pdf|msword|vnd.ms-powerpoint|vnd.openxmlformats-officedocument.presentationml.presentation|vnd.ms-excel|vnd.openxmlformats-officedocument.spreadsheetml.sheet|vnd.openxmlformats-officedocument.wordprocessingml.document)$/;
    
    
    if (!allowedTypes.test(file.type)) {
      alert('File type not allowed.');
      this.value="";
      return;
    }
    
    if (file.size > 1024 * 1024*100) {
      alert('File size should not exceed 100MB.');
      this.value="";
      return;
    }

    
  });
    
  
});
</script>