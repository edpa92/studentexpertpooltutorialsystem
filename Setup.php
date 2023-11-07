<?php
session_start();

if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}


if (!isset($_SESSION["RoleSEPTS"]) || $_SESSION["RoleSEPTS"] != "Admin" ) {
    header("location: 404.php");
    exit();
}


require_once 'Model/SchoolYearModel.php';
$sy=new SchoolYearModel();
require_once 'model/SubjectModel.php';
$sub=new SubjectModel();
require_once 'model/SectionModel.php';
$sec=new SectionModel();


require_once("views/header.php");
require_once("views/navi.php");
?>


<div class="container">
    <h1>System Setup</h1>
    <div class='alert alert-danger <?=(isset($_GET['m'])&&$_GET['m']!=""?"d-block":"d-none")?>'><?=(isset($_GET['m'])&&$_GET['m']!=""?$_GET['m']:"")?></div>
    <ul class="nav nav-tabs" id="setupTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="sy-tab" data-bs-toggle="tab" data-bs-target="#sy-tab-pane" type="button" role="tab" aria-controls="sy-tab-pane" aria-selected="true">School Year</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="sub-tab" data-bs-toggle="tab" data-bs-target="#sub-tab-pane" type="button" role="tab" aria-controls="sub-tab-pane" aria-selected="false">Subjects</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="class-tab" data-bs-toggle="tab" data-bs-target="#class-tab-pane" type="button" role="tab" aria-controls="class-tab-pane" aria-selected="false">Classe Sec</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        
        <div class="tab-pane fade show active " id="sy-tab-pane" role="tabpanel" aria-labelledby="sy-tab" tabindex="0">
    		<div class="p-3">
    		 
                <span><a class=" btn btn-primary float-end" href="SchoolYearAdd.php"> Add new</a></span>
                         
    			<table class="table">
             		<thead>
             			<tr>
             				<th>School Year</th>
             				<th>Status</th>
             				<th>Action</th>
             			</tr>
             		</thead>
             		<tbody>
             		<?php 
             		    $QueryResult=$sy->getAllSY();
             		    if (!is_null($QueryResult)) {
             		    while ($rowSY=$QueryResult->fetch_assoc()) {                         		        
             		        ?>
             			<tr>
             				<td><?php echo $rowSY['YearStart']."-".$rowSY['YearEnd']?></td>
             				<td><?php echo ($rowSY['Status']==1?'Active':'Inactive')?></td>
             				<td><a href="SchoolYearAdd.php?id=<?php echo$rowSY['SYCode'];?>" class="btn btn-primary  btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a></td>
             			</tr>
             		<?php }
             		    }
             		    ?>
             		</tbody>
             	</table>                
    		</div>
    	</div>
    	
    	<div class="tab-pane fade" id="sub-tab-pane" role="tabpanel" aria-labelledby="sub-tab" tabindex="0">     	
    		<div class="p-3">
    		<a class="btn btn-primary float-end" href="SubjectAdd.php"><i class="fa-solid fa-plus"></i> Add new</a>
                             
    			<table id="subjectTable" class="table">
                 	 <thead>
                 			<tr>
                 				<th>Code</th>
                 				<th>Subject</th>
                 				<th>Description</th>
                 				<th>Status</th>
                 				<th>Action</th>
                 			</tr>
                 		</thead>
                 		<tbody>
                     		<?php 
                     		$Result=$sub->getAllSubject();
                     		if (!is_null($Result)) {
                     		   while ($row=$Result->fetch_assoc()) {
                     		      ?>                     		      
                         			<tr>
                         				<td><?php echo $row['SubjectCode'];?></td>
                         				<td><?php echo $row['Subject'];?></td>
                         				<td><?php echo $row['Description'];?></td>
                         				<td><?php echo ($row['Status']==1? "active":"inactive");?></td>
                         				<td><a href="SubjectAdd.php?id=<?php echo$row['SubjectCode'];?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a></td>
                         			</tr>
                     		      <?php 
                     		   }
                     		}
                     		
                     		?>
             			</tbody>
                 	</table>
    		</div>
    	</div>
    	
        <div class="tab-pane fade" id="class-tab-pane" role="tabpanel" aria-labelledby="class-tab" tabindex="0">     	
    		<div class="p-3">
    		<a class="btn btn-primary float-end" href="SectionAdd.php"><i class="fa-solid fa-plus"></i> Add new</a>
                             
    			<table id="subjectTable" class="table">
                 	 <thead>
                 			<tr>
                 				<th>Code</th>
                 				<th>Class Sec</th>
                 				<th>Status</th>
                 				<th>Action</th>
                 			</tr>
                 		</thead>
                 		<tbody>
                     		<?php 
                     		$Result=$sec->getAll();
                     		if (!is_null($Result)) {
                     		   while ($row=$Result->fetch_assoc()) {
                     		      ?>                     		      
                         			<tr>
                         				<td><?php echo $row['SectionId'];?></td>
                         				<td><?php echo $row['Section'];?></td>
                         				<td><?php echo ($row['Status']==1? "active":"inactive");?></td>
                         				<td><a href="SectionAdd.php?id=<?php echo$row['SectionId'];?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a></td>
                         			</tr>
                     		      <?php 
                     		   }
                     		}
                     		
                     		?>
             			</tbody>
                 	</table>
    		</div>
    	</div>
    	
    	
    	
    </div>
    
</div>


<?php 
require_once("views/footer.php");    
?>