<?php
session_start();
if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}
if (!isset($_SESSION["RoleSEPTS"]) || $_SESSION["RoleSEPTS"] != "Admin") {
    header("location: 404.php");
}

require_once 'model/SubjectModel.php';

$sub=new SubjectModel();
$id=0;
$row=null;
if ($sub->isRequestPost()) {
    $id=$sub->escapeString($_POST['Id']);
    if ($id==0) {
            
            $sub->addSubject(
                $sub->escapeString($_POST['Subject']),
                $sub->escapeString($_POST['Description']),
                $sub->escapeString($_POST['Status']));
           
         
    }elseif($id>0) {
        $sub->EditSubject($id,
            $sub->escapeString($_POST['Subject']),
            $sub->escapeString($_POST['Description']),
            $sub->escapeString($_POST['Status']));
        
    }
    
    header("location: Setup.php?");
    exit();
}else{
    
    if (isset($_GET['id'])&&$_GET['id']!=""){
        $id=$sub->escapeString($_GET['id']);
        $row=$sub->getSubject($id);
        
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
                            <h6 class="m-0 font-weight-bold text-primary"> <i class="fa-solid fa-book-bookmark"></i><?php echo ($id>0?"Edit ":"Add"); ?> Subject</h6>
                            
							<div class="float-end">
                				<a href="Setup.php"
                					class="btn btn-secondary mx-2 btn-rounded btn-icon-text "><i
                					class="fa fa-arrow-left"></i> Back</a> 
                       		
							<button type="submit" class="btn btn-primary"> <i class="fa-solid fa-save"></i> Save</button>
                            </div>
                         	<table class="table "  id="SubjectAddTable">
                         		<thead><tr><td></td></tr></thead>
                         		<tbody>
                         			<tr>
                         				<td class="row">
                         					<div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                             	<input type="hidden" name="Id" value="<?php echo $id; ?>">
                                                  <div class="form-group">
                                                    <label for="formGroupExampleInput">Suject Name:*</label>
                                                    <input type="text" value="<?php echo (!is_null($row)&&!is_null($row['Subject'])? $row['Subject']:"") ?>" class="form-control" id="Subject" name="Subject" placeholder="Subject Name" required>
                                                  </div>
                                                  <div class="form-group">
                                                    <label for="formGroupExampleInput2">Description:*</label>
                                                    <textarea cols="5" class="form-control" id="Description" name="Description" placeholder="Description" required><?php echo (!is_null($row)&&!is_null($row['Description'])? $row['Description']:"") ?></textarea>
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
