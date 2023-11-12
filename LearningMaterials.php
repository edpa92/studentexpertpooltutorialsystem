<?php
session_start();

if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}
if (!isset($_SESSION["RoleSEPTS"]) || $_SESSION["RoleSEPTS"] != "Instructor") {
    header("location: 404.php");
}


require_once("model/LessonModel.php");
$les=new LessonModel();


require_once("model/MaterialsModel.php");
$mat=new MaterialsModel();


require_once("model/SubjectModel.php");
$sub=new SubjectModel();

require_once("views/header.php");
require_once("views/navi.php");
    ?>
    <div class="container">
    <h2 class="text-center">Learning Materials    	
                <a class="btn btn-primary float-end" href="LearningMaterialsAdd.php" role="button">Add Learning Materials</a>
    </h2>
    
   <ul class="nav nav-tabs">
   <?php 
   $subData=$sub->getAllSubjectThatHasTopicOfInstructor($_SESSION["EmpIdSEPTS"]);
       if (!is_null($subData)) {
           while ($row=$subData->fetch_assoc()) {
               ?>
                <li class="nav-item">
                    <a class="nav-link <?=(isset($_GET['sub'])&&$row['SubjectCode']==$_GET['sub']?"active":"")?>"   href="LearningMaterials.php?sub=<?=($row['SubjectCode'])?>"><?=($row['Subject'])?></a>
                </li>
          <?php 
           }
       }
   ?>
    </ul>
    <?php if (isset($_GET['sub'])) { ?>
       
    	<div class="row">
    		<div class="col-sm-12 col-md-6 col-lg-2 mt-3">
    			<ul class="nav flex-column">
    			<li class="nav-item">
                        <a class="nav-link disabled" aria-current="page"  >LESSONS</a>
                 </li>
    			<?php 
    			$lesO=$les->getAllActive($_SESSION["EmpIdSEPTS"],$_GET['sub']);
    			    if (!is_null($lesO)) {
    			        while ($row=$lesO->fetch_assoc()) { ?>     			
                      <li class="nav-item">
                        <a class="nav-link <?=(isset($_GET['id'])&&$_GET['id']==$row['TopicNo']?"disabled":"")?>" aria-current="page" href="LearningMaterials.php?sub=<?=$_GET['sub']?>&id=<?=$row['TopicNo']?>" ><?=$row['TopicDescription']?></a>
                      </li>
    			      <?php  }
    			    }
    			    ?>
                </ul>
                
                <a class="btn btn-primary mt-4" href="LessonsAdd.php" role="button">Add Lesson/Topic</a>
    		</div>
    		<div class="col-sm-12 col-md-6 col-lg-10">
    		<?php 
    		if (isset($_GET['id'])) {
    		        ?>
    			<table id='fancyTableMaterials' class="table table-hover table-responsive-md mt-3">
                  <thead>
                    <tr>
                      <th scope="col">Material#</th>
                      <th scope="col">Title</th>
                      <th scope="col">Lesson</th>
                      <th scope="col">Category</th>
                      <th scope="col">Status</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                  $matData=$mat->getAll();
                  if (isset($_GET['id'])&&$_GET['id']!="") {
                      $matData=$mat->getAllByTopic($mat->escapeString($_GET['id']));
                  }
                  if (!is_null($matData)) {
                      while ($row=$matData->fetch_assoc()) {?>   
                    <tr>
                      <td><?=$row['MaterialNo']?></td>
                      <td><?=$row['Title']?></td>
                      <td><?=$row['TopicDescription']?></td>
                      <td><?=$row['CategoryName']?></td>
                      <td><?=($row['Status']==0?"Inactive":"Active")?></td>
                      <td>
                      <a class="btn btn-primary " href="LearningMaterialsAdd.php?id=<?=$row['MaterialNo'];?>">Edit</a>
                      <a target="_blank" class="btn btn-primary " href="LearningMaterialsDetails.php?id=<?=($row['MaterialNo']);?>">View</a>
                      </td>
                    </tr>
                   <?php  }
                  }
                  ?>
                  </tbody>
                </table>
                <?php }
                
                ?>
    		</div>
    	</div>
    	<?php }?>
    	
    </div>
<?php 
require_once("views/footer.php");    
?>
<script>
	$(function(){
		$("#fancyTableMaterials").fancyTable({
				sortColumn:3,
				pagination: true,
				perPage: 50,
				globalSearch: true,
				inputPlaceholder: "Search here"
			});
	});
	
	
</script>