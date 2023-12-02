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


require_once("model/LessonModel.php");
$les=new LessonModel();

require_once("model/QuizModel.php");
$quiz=new QuizModel();


require_once("model/SubjectModel.php");
$sub=new SubjectModel();

require_once 'model/TakeQuizModel.php';
$takeO=new TakeQuizModel();


require_once("views/header.php");
require_once("views/navi.php");
?>
    <div class="container">
    <h2 class="text-center">Quizes
    </h2>
    
   <ul class="nav nav-tabs">
   <?php 
   $subData=$sub->getAllSubjectThatHasTopicOfInstructor($_SESSION["EmpIdSEPTS"]);
       if (!is_null($subData)) {
           while ($row=$subData->fetch_assoc()) {
               ?>
                <li class="nav-item">
                    <a class="nav-link <?=(isset($_GET['sub'])&&$row['SubjectCode']==$_GET['sub']?"active":"")?>"   href="Quizes.php?sub=<?=($row['SubjectCode'])?>"><?=($row['Subject'])?></a>
                </li>
          <?php 
           }
       }
   ?>
    </ul>
    <?php if (isset($_GET['sub'])&&$_GET['sub']!="") { 
        $subid=$sub->escapeString($_GET['sub']);
        ?>
       
    	<div class="row">
    		<div class="col-sm-12 col-md-6 col-lg-2 mt-3">
    			 <ul class="nav flex-column">
    			<li class="nav-item">
                        <a class="nav-link disabled" aria-current="page"  >LESSONS</a> 
                 </li>
    			<?php 
    			$lesO=$les->getAllActive($_SESSION["EmpIdSEPTS"],$subid);
    			    if (!is_null($lesO)) {
    			        while ($row=$lesO->fetch_assoc()) { ?>     			
                      <li class="nav-item">
                        <a class="nav-link <?=(isset($_GET['tid'])&&$_GET['tid']==$row['TopicNo']?"disabled":"")?>" aria-current="page" href="Quizes.php?sub=<?=$_GET['sub']?>&tid=<?=$row['TopicNo']?>" ><?=$row['TopicDescription']?></a>
                      </li>
    			      <?php  }
    			    } 
    			    ?>
               </ul>
                
    		</div>
    		<div class="col-sm-12 col-md-6 col-lg-10">
    		<?php 
    		if (isset($_GET['tid'])&&$_GET['tid']!="") {
    		    $topicid=$sub->escapeString($_GET['tid']);
    		    
    		    ?>    	
    			
			<div class="col-md-12">
    			<?php 
    			
    			$student_id=$_SESSION["RoleSEPTS"] == "Student"?$_SESSION["StudentId"]:0;
    			$quizes=$quiz->getAllQuizesOfTopic($topicid, $student_id);
    			
    			?>
    			<div class="table-responsive">			
                <a class="btn btn-primary float-end mt-2" href="QuizAddForTopic.php?t=<?=$topicid?>" role="button">Add Quiz</a>
    				<table class="table table-responsive">
                      <thead>
                        <tr>
                          <th scope="col">Quiz ID#</th>
                          <th scope="col">Date Posted</th>
                          <th scope="col">Passing (%)</th>
                          <th scope="col">Total Items</th>
                          <th scope="col"># of Question</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                      if (!is_null($quizes)) {
                          while ($row=$quizes->fetch_assoc()) { if(!is_null($row['QuizNo'])){ ?>                         
                            <tr>
                              <td><?=$row['QuizNo']?></td>
                              <td><?=$row['DatePosted']?></td>
                              <td><?=$row['PercentagePassing']?>%</td>
                              <td><?=$row['TotalItem']?> points</td>
                              <td><?=$row['QCount']?> Question(s)</td>
                              <td><?=($row['Status']==0?"Inactive":"Active")?></td>
                              <td>
                              <a href="QuizAddForTopic.php?t=<?=$topicid?>&q=<?=$row['QuizNo']?>" class="btn btn-primary btn-sm <?=($_SESSION["RoleSEPTS"] == "Instructor"?"d-inline":"d-none");?>">Edit</a>
                              <?php if($_SESSION["RoleSEPTS"] == "Student"&&$row['QCount']>0 && $row['Status']==1){?>
                              <a href="TakeQuiz.php?qid=<?=$row['QuizNo']?>" class="btn btn-sm btn-primary ">Take Quiz</a>
                             <?php }?>
                             <?php if(($_SESSION["RoleSEPTS"] == "Student" || $_SESSION["RoleSEPTS"] == "Instructor") && $row['TakenByStudent']>0){?>
                              <a data-bs-toggle="modal" data-bs-target="#quizModal<?=$row['QuizNo']?>" href="#" class="btn btn-sm btn-primary ">Details</a>
                             <?php }?>
                             
                                  <?php 
                                  if (($_SESSION["RoleSEPTS"] == "Student" || $_SESSION["RoleSEPTS"] == "Instructor")&&$row['TakenByStudent']>0) {                            
                                      ?>                      
                                <!-- Modal -->
                                <div class="modal fade" id="quizModal<?=$row['QuizNo']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-lg  modal-dialog-centered">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Quiz Details</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                        	<div class="table-responsive ">
                                                <table class="table border  table-hover">
                                                  <thead>
                                                    <tr>
                                                      <th scope="col">Taker</th>
                                                      <th scope="col">DateTaken</th>
                                                      <th scope="col">TotalScore</th>
                                                      <th scope="col">PassingScore</th>
                                                      <th scope="col">Remarks</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                  <?php 
                                                  $taken=$takeO->getAllTQStudent(isset($_SESSION["StudentId"])?$_SESSION["StudentId"]:"0");
                                        if (!is_null($taken)) {
                                            while ($rowT=$taken->fetch_assoc()) { ?>
                                                    <tr>
                                                      <td><?=($rowT['Firstname']." ".$rowT['Middlename']." ".$rowT['Lastname']." " .$rowT['NameExt'])?></td>
                                                      <td><?=($rowT['DateTaken'])?></td>
                                                      <td><?=($rowT['TotalScore'])?></td>
                                                      <td><?=($rowT['PassingScore'])?></td>
                                                      <td><?=($rowT['Remarks'])?></td>
                                                    </tr> 
                                                    <?php  }
                                                    }
                                                ?>  
                                                  </tbody>
        										</table>
        									</div>	
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>                      
                                <!-- Modal END-->
                                <?php }?>
                              
                              </td>
                            </tr>
                            
                        <?php } }  }?>
                      </tbody>
                    </table>
                    </div>
    			</div>
                <?php  }
                
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