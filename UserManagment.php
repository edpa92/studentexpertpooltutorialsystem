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


require_once ('model/InstructorModel.php');
$ins=new InstructorModel();


require_once ('model/StudentModel.php');
$stud=new StudentModel();

require_once("views/header.php");
require_once("views/navi.php");
?>
<div class="container">
    <h1>User Management</h1>      
      <?php 
		if (isset($_GET['m']) && $_GET['m']!="") {
		    echo "<div class='alert alert-success'>".$_GET['m']."</div>";
		}
		?>
    <ul class="nav nav-tabs" id="usersTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="ins-tab" data-bs-toggle="tab" data-bs-target="#ins-tab-pane" type="button" role="tab" aria-controls="ins-tab-pane" aria-selected="true">Instructor</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="stud-tab" data-bs-toggle="tab" data-bs-target="#stud-tab-pane" type="button" role="tab" aria-controls="stud-tab-pane" aria-selected="false">Student</button>
      </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active <?php ?>" id="ins-tab-pane" role="tabpanel" aria-labelledby="ins-tab" tabindex="0">
    		<div class="p-3">
    			
    			<table id='fancyTableIns' class="table table-responsive table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Emp Id#</th>
                      <th scope="col">Fullname </th>
                      <th scope="col">Email</th>
                      <th scope="col">Status</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $insAll=$ins->getAll();
                  if (!is_null($insAll)) {
                      while ($row= $insAll->fetch_assoc()) {
                        
                  ?>
                    <tr>
                      <td scope="row"><?=$row['EmpId']?></td>
                      <td><?=$row['Firstname']?> <?=$row['MI']?> <?=$row['Lastname']?> <?=$row['NameExt']?></td>
                      <td><?=$row['Email']?></td>
                      <td><?=($row['Verified']==0?"Unverified":"Verified")?></td>
                      <td><a class="btn btn-primary btn-small <?=($row['Verified']==0?"d-block":"d-none")?>" href="VerifyInstructor.php?id=<?=$row['EmpKey'];?>"> Verify</a></td>
                    </tr>
                    <?php  ;
                     }
                  } ?>
                  </tbody>
                </table>
                
    		</div>
    	</div>
         <div class="tab-pane fade" id="stud-tab-pane" role="tabpanel" aria-labelledby="stud-tab" tabindex="0">     	
    		<div class="p-3">
    			
    			<table id='fancyTableStud' class="table table-responsive table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Id#</th>
                      <th scope="col">Student Fullname </th>
                      <th scope="col">Email</th>
                      <th scope="col">Status</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $studAll=$stud->getAllStudent();
                  if (!is_null($studAll)) {
                      while ($row= $studAll->fetch_assoc()) {
                        
                  ?>
                    <tr>
                      <td scope="row"><?=$row['StudentIDNo']?></td>
                      <td><?=$row['Firstname']?> <?=$row['Middlename']?> <?=$row['Lastname']?> <?=$row['NameExt']?></td>
                      <td><?=$row['Email']?></td>
                      <td><?=($row['EmailVerified']==0?"Unverified":"Verified")?></td>
                      <td><a class="btn btn-primary btn-small <?=($row['EmailVerified']==0?'d-block':'d-none');?>" href="VerifyStudent.php?id=<?=$row['StudentId']?>"> Verify</a></td>
                    </tr>
                    <?php  ;
                     }
                  } ?>
                  </tbody>
                </table>    
                            
    		</div>
    	</div>
    </div>
    
    
</div>
<?php 
require_once("views/footer.php");    
?>
<script>
	$(function(){
		$("#fancyTableIns").fancyTable({
				sortColumn:3,
				pagination: true,
				perPage: 25,
				globalSearch: true,
				inputPlaceholder: "Search here"
			});
	});
	
	
	$(function(){
		$("#fancyTableStud").fancyTable({
				sortColumn:3,
				pagination: true,
				perPage: 25,
				globalSearch: true,
				inputPlaceholder: "Search here"
			});
	});
</script>