<?php
session_start();
if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}
if (!isset($_SESSION["RoleSEPTS"]) || $_SESSION["RoleSEPTS"] != "Admin") {
    header("location: 404.php");
    exit();
}

require_once 'model/ProgressBasisModel.php';

$progM=new ProgressBasisModel();
$id=0;
$row=null;

if ($progM->isRequestPost()) {
   
    $progbasis=$progM->escapeString($_POST['ProgressBasis']);
    $progbasisLow=$progM->escapeString($_POST['ProgressBasisLow']);
    $progbasisHigh=$progM->escapeString($_POST['ProgressBasisHigh']);
    $id=$progM->escapeString($_POST['Id']);
    
    $progM->addEditProgressBasis($id, $progbasis, $progbasisLow, $progbasisHigh);
    
    header("location: ProgressBasis.php");
    exit();
    
    
}else{
    
    if (isset($_GET['id']) && $_GET['id']!="") {
        $id=$progM->escapeString($_GET['id']);
        $row=$progM->getProgressBasis($id);
        
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
                     <div class="w-lg-50">
                            <h6 class="m-0 font-weight-bold text-primary"> <i class="fa-solid fa-book-bookmark"></i><?php echo ($id>0?"Edit ":"Add"); ?> Instructor Progress Basis</h6>
                            
							<div class="float-end">
                				<a href="ProgressBasis.php"
                					class="btn btn-secondary mx-2 btn-rounded btn-icon-text "><i
                					class="fa fa-arrow-left"></i> Back</a> 
                       		
							<button type="submit" class="btn btn-primary"> <i class="fa-solid fa-save"></i> Save</button>
                            </div>
                         	<table class="table "  >
                         		<thead><tr><td></td></tr></thead>
                         		<tbody>
                         			<tr>
                         				<td class="row">
                         					<div class="col-sm-12 col-md-6 col-lg-8 col-xl-8">
                                             	<input type="hidden" name="Id" value="<?php echo $id; ?>">
                                                  <div class="form-group">
                                                    <label for="formGroupExampleInput">Progress Basis:*</label>
                                                    <input type="text" value="<?=(!is_null($row)?$row['ProgressBasis']:"")?>" class="form-control" id="ProgressBasis" name="ProgressBasis" placeholder="ex: Low Progress or Average Progress etc" required>
                                                  </div>
                                                  	<div class="row mt-3">
                                                    <label for="formGroupExampleInput mt-4">Progress Basis Lower limit(%)- Higher limit(%):*</label>
                                                      <div class="col">
                                                        <input type="number" step=".01" value="<?=(!is_null($row)?$row['LowerLimit']:"")?>" id="ProgressBasisLow" name="ProgressBasisLow"  class="form-control" placeholder="" >
                                                      </div>%
                                                      TO
                                                      <div class="col">
                                                        <input type="number" step=".01" value="<?=(!is_null($row)?$row['HigherLimit']:"")?>" id="ProgressBasisHigh" name="ProgressBasisHigh" class="form-control" placeholder="" >
                                                      </div>%
                                                    </div>
                								</div> 

                         				</td>
                         			</tr>
                         		</tbody>
                         	</table>
                    </div>

                  </form>
                </div>
                <!-- /.container-fluid -->

           
          
    
<?php 
require_once("views/footer.php");    
?>
