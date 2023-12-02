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


require_once ('model/MaterialsModel.php');
$matO=new MaterialsModel();


require_once ('model/QuizModel.php');
$QO=new QuizModel();

require_once ('model/TakeQuizModel.php');
$tqM=new TakeQuizModel();

$matid=0;
$mat=null;
$qid=0;
$qui=null;
$quiz_has_been_taken=FALSE;

if ($ins->isRequestPost()) {
    
    try {
        
        $qid=$matO->escapeString($_POST['qid']);
        $matid=$matO->escapeString($_POST['matid']);
        $topicid=$matO->escapeString($_POST['topicid']);
        $passing=$matO->escapeString($_POST['passing']);
        $total=$matO->escapeString($_POST['totalitem']);
        $statusq=$matO->escapeString($_POST['statusq']);
        $currentDate = $QO->getCurrentDate();
        $retake=isset($_POST['retake'])?1:0;
        
        $quizid=$QO->addEditQuiz($qid, $matid, $currentDate, $passing, $total, $statusq, $topicid, $retake);
        
        
        $quiz_has_been_taken=$QO->isQuizTaken($qid);
        
        if ($quiz_has_been_taken && $quizid) {
            $takes=$tqM->getAllTQ($qid);
            if (!is_null($takes)) {
                while ($rowTake=$takes->fetch_assoc()) {
                    $tq_id=$rowTake['TakeNo'];
                    $takescore=$rowTake['TotalScore'];
                    $PassingScore=($total*($passing/100));
                    
                    $tqM->editScoreTQ($tq_id, $takescore, $PassingScore, ($takescore>=$PassingScore?"Passed":"Failed"));
                    
                }
            }
        }
        
        if (!is_bool($quizid)&&$quizid>0) {
            if (isset($_POST['question']) && count($_POST['question'])>0) {
                for ($i = 0; $i < count($_POST['question']); $i++) {
                    
                    $QO->addQuestion(
                        $quizid,
                        $matO->escapeString($_POST['question'][$i]),
                        $matO->escapeString($_POST['ansA'][$i]),
                        $matO->escapeString($_POST['ansB'][$i]),
                        $matO->escapeString($_POST['ansC'][$i]),
                        $matO->escapeString($_POST['ansD'][$i]),
                        $matO->escapeString($_POST['ans'][$i]),
                        1,
                        $matO->escapeString($_POST['points'][$i]));
                }
            }
        }elseif ($quizid && !$quiz_has_been_taken){
            
            $QO->deleteAllQuestionsOfQuiz($qid);
            if (isset($_POST['question']) && count($_POST['question'])>0) {
                for ($i = 0; $i < count($_POST['question']); $i++) {
                    
                    $QO->addQuestion(
                        $qid,
                        $matO->escapeString($_POST['question'][$i]),
                        $matO->escapeString($_POST['ansA'][$i]),
                        $matO->escapeString($_POST['ansB'][$i]),
                        $matO->escapeString($_POST['ansC'][$i]),
                        $matO->escapeString($_POST['ansD'][$i]),
                        $matO->escapeString($_POST['ans'][$i]),
                        1,
                        $matO->escapeString($_POST['points'][$i]));
                }
            }
            
        }
        
        
        header("location: LearningMaterialsDetails.php?id=".$matid);
        exit();
        
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    
    
}else{
    
    if (isset($_GET['m'])&&$_GET['m']!="") {
        $matid=$_GET['m'];
        $mat=$matO->get($matid);
        
        if (is_null($mat)) {
            header("location: 404.php");
            exit();
        }
        
        
        if (isset($_GET['q'])&&$_GET['q']!="") {
            $qid=$QO->escapeString($_GET['q']);
            $qui=$QO->getQuiz($qid);
            
            if (is_null($qui)) {
                header("location: 404.php");
                exit();
            }
            
            $quiz_has_been_taken=$QO->isQuizTaken($qid);
        }
        
    }else {
        header("location: 404.php");
        exit();
    }
}

require_once("views/header.php");
require_once("views/navi.php");
?>

    <div class="container"> 
    
  	<div id="q" class="d-none">
  		<div class="q">
        <h5 class="card-title text-center">--- Question ---  <a class="removebtn" href="#"><i class="bi bi-x-square-fill float-end"></i></a></h5> 
        <small>Question:</small>
        <textarea name="question[]" class="form-control" rows="3" cols="" placeholder="Ex: What is the sum of 2 & 3?" required="required"></textarea>
        <div class="row g-3 ">
          <div class="col">
           A. <input name="ansA[]" type="text" class="form-control" placeholder="2"  required="required">
          </div>
          <div class="col">
           B. <input name="ansB[]" type="text" class="form-control" placeholder="8"  required="required">
          </div>                              
        </div>
        <div class="row g-3 ">
          <div class="col">
            C. <input name="ansC[]" type="text" class="form-control" placeholder="5"  required="required">
          </div>
          <div class="col">
            D. <input name="ansD[]" type="text" class="form-control" placeholder="7"  required="required">
          </div>                              
        </div>
        <div class="row g-3 mt-1">
          <div class="col">                              
        	<small>Letter of the answer:</small>                       
            <select id="ans" name="ans[]" class="form-select" required="required">
              <option value="" selected>What is the Letter of the answer?...</option>
              <option  value="A">A</option>
              <option value="B">B</option>
              <option  value="C">C</option>
              <option value="D">D</option>
            </select>
          </div>
          <div class="col">
          	<small>How many Points:</small>
            <input type="number" name="points[]" class="form-control pointstxt" placeholder="How many Points"  required="required">
          </div>
        </div>
        <hr>
    </div>
    </div>
    
    
    	<form action="" method="post">
    	<input type="hidden" value="<?=($mat['TopicId'])?>" name="topicid">
    	<input type="hidden" value="<?=$matid;?>" name="matid">
    	<input type="hidden" value="<?=$qid;?>" name="qid">
        <h1 class=""><?=(!is_null($qui)?"Edit":"Add")?> Quiz 
                    <button type="submit" class="btn btn-primary float-end">SAVE QUIZ</button> </h1>
            <div class="row">      
            	<div class="col-md-6">            			
           			<div class="card m-2">
                      <div class="card-header">
                        Quiz Details 
                      </div>
                      <div class="card-body">
                      	<a target="_blank" class="icon-link" href="LearningMaterialsDetails.php?id=<?=($mat['MaterialNo']);?>">
                          <h4><?=($mat['Title'])?>
                          <i class="bi bi-box-arrow-in-up-right"></i></h4>
                        </a>
                        <h5 class="card-title">(<?=($mat['Subject'])?>) <?=($mat['TopicDescription'])?></h5>
                        <div class="row g-3 mt-1">
                          <div class="col">
                          <small>Percentage Passing (%)</small>                            
                        	<input value="<?=(!is_null($qui)?$qui['PercentagePassing']:"")?>" name="passing" type="number" step=".01" class="form-control" placeholder="0.0 %" required="required">
                          </div>
                          <div class="col">
                          <small>Total Item</small>
                            <input value="<?=(!is_null($qui)?$qui['TotalItem']:"0")?>" name="totalitem" step=".01" id="totalitem" type="number" class="form-control" placeholder="Total Item"  readonly="readonly">
                          </div>                          
                          <div class="col">
                          	<small>Quiz Status:</small>                    
                            <select id="statusq" name="statusq" class="form-select" required="required">
                              <option value="" selected>Choose Status...</option>
                              <option  value="1" <?=(!is_null($qui)&&$qui['Status']=="1"?"Selected":"");?>>Active</option>
                              <option value="0" <?=(!is_null($qui)&&$qui['Status']=="0"?"Selected":"");?>>Inactive</option>
                            </select>
                          </div>                    
                        </div>
                          <div class="form-check mt-3 ">
                              <input value="1" class="form-check-input" type="checkbox" id="retake" name="retake" <?=(!is_null($qui)&&$qui['Retaking']=="1"?"Checked":"");?>>
                              <label class="form-check-label" for="retake">
                                <strong>Allow students to Retake this Quiz more than once?</strong>
                              </label>
                          </div>
                      </div>
                    </div>           			
            	</div>      
            	<div class="col-md-6">        		
           			<div class="card m-2">
                      <div class="card-header">
                        Quiz Questions
                        <?php if (!$quiz_has_been_taken) {
                            ?>
                        <a id="addQ" href="#" class="btn btn-primary btn-sm float-end">+ Question</a>
                        <?php }?>
                        
                      </div>
                      <div class="card-body " id="cardbodyQ">                      	
                      	<?php 
                      	if ($quiz_has_been_taken) {
                      	    echo "<div class='alert alert-danger'>Quiz has already been taken by some of the students, you can no longer allowed to modify its questions. But you can modify the Passing Rate of this quiz or Deactivate(To prevent students take the Quiz) it.</div>";
                      	}else{
                      	if ($qid>0) {
                      	     $questions=$QO->getAllQuestionsOfQuiz($qid); 
                      	    if (!is_null($questions)) {
                      	        while ($rowQ=$questions->fetch_assoc()) {?>
                      	            <div>
                                  		<div class="q">
                                        <h5 class="card-title text-center">--- Question ---  <a class="removebtn" href="#"><i class="bi bi-x-square-fill float-end"></i></a></h5> 
                                        <small>Question:</small>
                                        <textarea name="question[]" class="form-control" rows="3" cols="" placeholder="Ex: What is the sum of 2 & 3?" required="required"><?=($rowQ['Question']);?></textarea>
                                        <div class="row g-3 ">
                                          <div class="col">
                                           A. <input value="<?=($rowQ['ChoiceA']);?>" name="ansA[]" type="text" class="form-control" placeholder="2"  required="required">
                                          </div>
                                          <div class="col">
                                           B. <input value="<?=($rowQ['ChoiceB']);?>" name="ansB[]" type="text" class="form-control" placeholder="8"  required="required">
                                          </div>                              
                                        </div>
                                        <div class="row g-3 ">
                                          <div class="col">
                                            C. <input value="<?=($rowQ['ChoiceC']);?>" name="ansC[]" type="text" class="form-control" placeholder="5"  required="required">
                                          </div>
                                          <div class="col">
                                            D. <input value="<?=($rowQ['ChoiceD']);?>" name="ansD[]" type="text" class="form-control" placeholder="7"  required="required">
                                          </div>                              
                                        </div>
                                        <div class="row g-3 mt-1">
                                          <div class="col">                              
                                        	<small>Letter of the answer:</small>                       
                                            <select id="ans" name="ans[]" class="form-select" required="required">
                                              <option value="" selected>What is the Letter of the answer?...</option>
                                              <option value="A" <?=($rowQ['Answer']=="A"?"Selected":"");?>>A</option>
                                              <option value="B" <?=($rowQ['Answer']=="B"?"Selected":"");?>>B</option>
                                              <option  value="C" <?=($rowQ['Answer']=="C"?"Selected":"");?>>C</option>
                                              <option value="D" <?=($rowQ['Answer']=="D"?"Selected":"");?>>D</option>
                                            </select>
                                          </div>
                                          <div class="col">
                                          	<small>How many Points:</small>
                                            <input value="<?=($rowQ['Points']);?>" type="number" name="points[]" class="form-control pointstxt" placeholder="How many Points"  required="required">
                                          </div>
                                                                  
                                        </div>
                                        <hr>
                                    	</div>
                                    </div>
                  	       	<?php  }
                      	    } 	        
                      }else{
                          	?>                      	
                      	<div>
                      		<div class="q">
                            <h5 class="card-title text-center">--- Question ---  <a class="removebtn" href="#"><i class="bi bi-x-square-fill float-end"></i></a></h5> 
                            <small>Question:</small>
                            <textarea name="question[]" class="form-control" rows="3" cols="" placeholder="Ex: What is the sum of 2 & 3?" required="required"></textarea>
                            <div class="row g-3 ">
                              <div class="col">
                               A. <input name="ansA[]" type="text" class="form-control" placeholder="2"  required="required">
                              </div>
                              <div class="col">
                               B. <input name="ansB[]" type="text" class="form-control" placeholder="8"  required="required">
                              </div>                              
                            </div>
                            <div class="row g-3 ">
                              <div class="col">
                                C. <input name="ansC[]" type="text" class="form-control" placeholder="5"  required="required">
                              </div>
                              <div class="col">
                                D. <input name="ansD[]" type="text" class="form-control" placeholder="7"  required="required">
                              </div>                              
                            </div>
                            <div class="row g-3 mt-1">
                              <div class="col">                              
                            	<small>Letter of the answer:</small>                       
                                <select id="ans" name="ans[]" class="form-select" required="required">
                                  <option value="" selected>What is the Letter of the answer?...</option>
                                  <option  value="A">A</option>
                                  <option value="B">B</option>
                                  <option  value="C">C</option>
                                  <option value="D">D</option>
                                </select>
                              </div>
                              <div class="col">
                              	<small>How many Points:</small>
                                <input type="number" name="points[]" class="form-control pointstxt" placeholder="How many Points"  required="required">
                              </div>
                              <!-- <div class="col">
                              	<small>Status:</small>                    
                                <select id="status" name="status[]" class="form-select" required="required">
                                  <option value="" selected>Choose Status...</option>
                                  <option  value="1">Active</option>
                                  <option value="0">Inactive</option>
                                </select>
                              </div>    -->                           
                            </div>
                            <hr>
                        	</div>
                        </div>
                        <?php } }?>
                        
                        
                      </div>
                    </div>
            	</div>       		
            </div>
        </form>
    </div>
<?php 
require_once("views/footer.php");    
?>
<script>
$(function(){
	//var pointsArr = [];
		  var totalPoints=0
	$(document).on('click', '#addQ', function(){
	 
	 var q=$("#q").html();	 	 
	 	$("#cardbodyQ").append(q);	  
	});
	

	
	$(document).on('click', '.removebtn', function() {
		var pos = $('.removebtn').index(this);		 
			$('.q:eq('+(pos)+')').remove();
	});
	
	$(document).on('focusout', '.pointstxt', function() {
		 
    	var totalValue = 0;
	    $('.pointstxt').each(function() {
	      var textboxValue = $(this).val();
	      console.log(textboxValue);
	      if (!isNaN(parseFloat(textboxValue))) {
	      totalValue += parseFloat(textboxValue);
	      }
	    });
    			
		$("#totalitem").val(totalValue);
		  
	});
	
	
});
</script>
 