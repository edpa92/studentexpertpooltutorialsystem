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

require_once("views/header.php");
require_once("views/navi.php");
    ?>
    <div class="container">
    	<div class="row">
    		<div class="col-sm-12 col-md-6 col-lg-4">
    			<ul class="nav flex-column">
    			<?php 
    			$lesO=$les->getAllActive($_SESSION["EmpIdCSHS"]);
    			    if (!is_null($lesO)) {
    			        while ($row=$lesO->fetch_assoc()) { ?>     			
                      <li class="nav-item">
                        <a class="nav-link <?=(isset($_GET['id'])&&$_GET['id']==$row['TopicNo']?"disabled":"")?>" aria-current="page" href="LearningMaterials.php?id=<?=$row['TopicNo']?>" ><?=$row['TopicDescription']?></a>
                      </li>
    			      <?php  }
    			    }
    			    ?>
                </ul>
                
                <a class="btn btn-primary mt-4" href="LessonsAdd.php" role="button">Add Lesson/Topic</a>
    		</div>
    		<div class="col-sm-12 col-md-6 col-lg-8">
    		
    		</div>
    	</div>
    </div>
<?php 
require_once("views/footer.php");    
?>