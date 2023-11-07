<?php
session_start();
if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}
if (!isset($_SESSION["RoleSEPTS"]) || $_SESSION["RoleSEPTS"] != "Admin") {
    header("location: 404.php");
}

require_once 'model/SectionModel.php';
$sec=new SectionModel();

require_once 'model/SubjectModel.php';
$sub=new SubjectModel();


$id=0;
$row=null;
if ($sec->isRequestPost()) {
    $id=$sec->escapeString($_POST['Id']);
       
        $result=$sec->addEdit($id,
            $sec->escapeString($_POST['Section']),
            $sec->escapeString($_POST['Status']));        
        
    if (is_bool($result) && !$result) {    
    header("location: Setup.php?m='".$sec->escapeString($_POST['Section'])."'  Class Section Already exist!");
    exit();        
    }
    
    if ($id==0 && $result>0 && isset($_POST['flexSwitchSub'])) {
        for ($i = 0; $i < count($_POST['flexSwitchSub']); $i++) {
            $sec->addSectionSub($result, $sec->escapeString($_POST['flexSwitchSub'][$i]));
        }
    }elseif ($id>0 && $result) {
        $sec->deleteAllSectionSubs($id);
        if (isset($_POST['flexSwitchSub'])) {
            for ($i = 0; $i < count($_POST['flexSwitchSub']); $i++) {
                $sec->addSectionSub($id, $sec->escapeString($_POST['flexSwitchSub'][$i]));
            }
        }
    }
    
    
    header("location: Setup.php?m");
    exit();
}else{
    
    if (isset($_GET['id'])&&$_GET['id']!=""){
        $id=$sec->escapeString($_GET['id']);
        $row=$sec->get($id);
        
        if (is_null($row)) {
            
            header("location: 404.php");
            exit();
        }
    }
    
}


require_once("views/header.php");
require_once("views/navi.php");?>

                <!-- Begin Page Content -->
                <div class="container">

              <form method="post">
                    <!-- Page Heading -->
                     <div>
                            <h6 class="m-0 font-weight-bold text-primary"> <i class="fa-solid fa-book-bookmark"></i><?php echo ($id>0?"Edit ":"Add"); ?> Section                            
							<div class="float-end">
                				<a href="Setup.php"
                					class="btn btn-secondary mx-2 btn-rounded btn-icon-text "><i
                					class="fa fa-arrow-left"></i> 
                					Back
                					</a>                        		
							<button type="submit" class="btn btn-primary"> <i class="fa-solid fa-save"></i> Save</button>
                            </div>
                            </h6>
                            <div class="row mt-2">
                            	<div class="col-sm-12 col-lg-6">
                             	<input type="hidden" name="Id" value="<?php echo $id; ?>">
                                  <div class="form-group">
                                    <label for="formGroupExampleInput">Class Section (ex:1-BSCE-A,1-BSCE-B):*</label>
                                    <input type="text" value="<?php echo (!is_null($row)&&!is_null($row['Section'])? $row['Section']:"") ?>" class="form-control" id="Section" name="Section" placeholder="1-BSCE-A" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="formGroupExampleInput2">Status:*</label>                                
										<select id="Status" name="Status"
											class="form-control" required>
											<option value="">--Select Status--</option>
											<option value="1"
												<?php if (!is_null($row) && $row['Status'] == '1') { echo 'selected';}?>>Active</option>
											<option value="0"
												<?php if (!is_null($row) && $row['Status'] == '0') { echo 'selected';}?>>Inactive</option>
										</select>
    								</div>                      								
                            	</div>
                            	<div class="col-sm-12 col-lg-6">
                            		<h3 class="mt-2">Check Subject for this Class Section</h3>
                            		<?php 
                            		    $subQ=$sub->getAllActiveSubject();
                            		    if ($id>0) {                            		        
                            		        $subQ=$sub->getAllSubject();
                            		    }
                            		    if (!is_null($subQ)) {
                            		        while ($row=$subQ->fetch_assoc()) { ?>                            		   
                                		
                                		
                                		<h5 class="form-check form-switch">
                                          <input class="form-check-input" value="<?=$row['SubjectCode'];?>" type="checkbox" role="switch" id="flexSwitchSub" name="flexSwitchSub[]" <?php echo ($sec->classSubExist($id, $row['SubjectCode'])?"Checked":""); ?>>
                                          <label class="form-check-label" for="flexSwitchSub"><?=$row['Subject'];?></label>
                                        </h5>
                                        

                                    <?php         
                        		      }
                        		    }
                            		?>
                            	</div>
                            </div>
                            
                         	
                         	
                    </div>
                  </form>
                </div>
                <!-- /.container-fluid -->

           
          
    
<?php 
require_once("views/footer.php");    
?>
