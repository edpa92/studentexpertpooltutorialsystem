<?php

session_start();
if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}
if (!isset($_SESSION["RoleSEPTS"]) || $_SESSION["RoleSEPTS"] != "Admin") {
    header("location: 404.php");
}

require_once 'model/SchoolYearModel.php';

$id=0;
$row=null;
$sy=new SchoolYearModel();
    if ($sy->isRequestPost()) {
        
        $sy->addEditSY($sy->escapeString($_POST['Id']), 
            $sy->escapeString($_POST['SYStart']),             
            $sy->escapeString($_POST['SYEnd']),             
            $sy->escapeString($_POST['Status']));
        
        header("location:  Setup.php");
        exit();
        
    }else {
        
        if (isset($_GET['id'])&&$_GET['id']!=""){
            $id=$sy->escapeString($_GET['id']);
            $row=$sy->getSY($id);
            if (is_null($row)) {
                
                header("location: 404.php");
                exit();
            }
        }
    }

    
    
    require_once("views/header.php");
    require_once("views/navi.php");?>
<!-- partial:partials/_sidebar and navar END-->

        <!-- Begin Page Content -->
        <div class="container">

            <!-- Page Heading -->
             <div class="mb-4 w-50">
                 <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fa-solid fa-calendar-days"></i>Add School Year (SY)</h6>
                 </div>
                 <div class="card-body">
                 <form method="post">
                 	<input type="hidden" name="Id" value="<?php echo $id; ?>">
                      <div class="form-group">
                        <label for="formGroupExampleInput">Year Start:*</label>
                        <input min="<?php echo date('Y'); ?>"  type="number" value="<?php echo (!is_null($row)&&!is_null($row['YearStart'])? $row['YearStart']:"") ?>" class="form-control" id="SYStart" name="SYStart" placeholder="School Year Start" required>
                      </div>
                      <div class="form-group">
                        <label for="formGroupExampleInput2">Year End:*</label>
                        <input type="number" value="<?php echo (!is_null($row)&&!is_null($row['YearEnd'])? $row['YearEnd']:"") ?>" class="form-control" id="SYEnd" name="SYEnd" placeholder="School Year End" required>
                       </div>
                      <div class="form-group mb-2">
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
						<button type="submit" class="btn btn-primary float-right"> <i class="fa-solid fa-save"></i> Save</button>
                   		
            				<a href="Setup.php"
            					class="btn btn-secondary mx-2 btn-rounded btn-icon-text float-right"><i
            					class="fa fa-arrow-left"></i> Back</a> 
                    </form>
                 </div>
            </div>

        </div>
        <!-- /.container-fluid -->

           
    
<?php 
require_once("views/footer.php");    
?>