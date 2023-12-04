<?php
    session_start();
    
    if (!isset($_SESSION["loggedinSEPTS"])) {
        header("location: login.php");
        exit();
    }
    
    if (!isset($_SESSION["RoleSEPTS"]) || $_SESSION["RoleSEPTS"] != "Student") {
        header("location: 404.php");
        exit();
    }
    
    
    require_once ('model/QuizModel.php');
    $QO=new QuizModel();
    
    require_once ('model/TakeQuizModel.php');
    $TQO=new TakeQuizModel();
    
    
    require_once ('model/SectionModel.php');
    $secM=new SectionModel();
    
    $qid=0;
    $take_id=0;
    
    if ($TQO->isRequestPost()) {
        
        $studid=$_SESSION["StudentId"];
        $quizid=$TQO->escapeString($_POST['qid']);
        $duration=$TQO->escapeString($_POST['timer']);
        
        $takeid=$TQO->addTQ(
            $take_id, 
            $studid, 
            $quizid, 
            $TQO->getCurrentDate(), 
            1,
            $duration, $secM->getTopSY()); 
        
        if ($takeid>0 && count($_POST['questionid'])>0) {
            $totalPoints=0;
            $Remarks="Failed";
            for ($i = 0; $i < count($_POST['questionid']); $i++) {
                
                $question_id=$TQO->escapeString($_POST['questionid'][$i]);
                $choosen_ans=$TQO->escapeString($_POST['flexRadioQ'.$question_id]);
                $correct_ans=$TQO->escapeString($_POST['ans'][$i]);
                $points=$TQO->escapeString($_POST['points'][$i]);
                
                 $TQO->addAnswer($takeid, 
                    $question_id, 
                    $choosen_ans,
                    ($choosen_ans==$correct_ans));
                
                if ($choosen_ans==$correct_ans) {                    
                    $totalPoints+=$points;
                }                
              }
              
              $quiz=$QO->getQuiz($quizid);
              $passing=$quiz['PercentagePassing'];
              $totalitem=$quiz['TotalItem'];
              $passingscore=($totalitem*($passing/100));
             
              if ($totalPoints>=$passingscore) {
                  $Remarks="Passed";
              }
              
              $TQO->editScoreTQ($takeid, $totalPoints, $passingscore, $Remarks);
              header("location: LearningMaterialsDetails.php?id=".$quiz['MaterialId']);
              exit();
        }
    
    }else {
        if (!isset($_GET['qid']) || $_GET['qid']=="") {
            header("location: 404.php");
            exit();
        }
        
        $qid=$QO->escapeString($_GET['qid']);
        $quiz=$QO->getQuizToTake($qid);
        if (is_null($quiz) || $quiz['Status']==0 || (!$QO->isQuizAllowedTotake($qid, $_SESSION["StudentId"]))) {
            header("location: 404.php");
            exit();
        }
        
    }
    
    
    require_once("views/header.php");
    require_once("views/navi.php");
        ?>
    <div class="container">
    	<form method="post" action="">      	
    	  	<div class="row"> 	
         		<h4>Quiz For: <?=$quiz['Subject'];?> (<small><?=$quiz['TopicDescription'];?></small>)
         			<button class="btn btn-primary float-end" type="submit">Submit Answers</button>
         		</h4>
     		</div>
    	  <div class="row">
    	  	<div class="col-lg-3 col-md-6 col-sm-6">
        	  	<small>Quiz No:</small>
         		<input class="form-control" name="qid" type="text" value="<?=$qid;?>" readonly>
    	  	</div>
    	  	<div class="col-lg-3 col-md-6 col-sm-6">
        	  	<small>Timer:</small>
         		<input class="form-control text-warning" name="timer" type="text" id="timer" value="00:00" readonly>
    	  	</div>
    	  	<div class="col-lg-3 col-md-6 col-sm-6">
        	  	<small>Passing %:</small>
         		<input class="form-control" type="text" value="<?=$quiz['PercentagePassing'];?>%" disabled="disabled"> 
    	  	</div>
    	  	<div class="col-lg-3 col-md-6 col-sm-6">
        	  	<small>Total Items:</small>
         		<input class="form-control"  type="text"  value="<?=$quiz['TotalItem']."points (".$quiz['QCount']." Questions)";?>" disabled="disabled">
    	  	</div>
     	  </div>
    	  <div class="p-4">
    	  <?php 
    	      $questions=$QO->getAllQuestionsOfQuiz($qid);
    	      if (!is_null($questions)) {
    	          $counte=1;
    	          while ($row=$questions->fetch_assoc()) { 
    	      
    	  ?>
    	 	 <div class="row py-3 border">
    	  	 <input type="hidden" name="questionid[]" value="<?=$row['QQId']?>">
    	  	 <input type="hidden" name="ans[]" value="<?=$row['Answer']?>">
    	  	 <input type="hidden" name="points[]" value="<?=$row['Points']?>">
        	  	<div class="col-12">
        	  		<strong><?=$counte.". " .($row['Question'])." <em class='text-secondary'>(".$row['Points']."points)</em>";?></strong>
        	  	</div>
        	  	<div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="form-check">
                      <input value="A" class="form-check-input" type="radio" name="flexRadioQ<?=$row['QQId']?>" id="flexRadioA<?=$row['QQId']?>" required="required">
                      <label class="form-check-label" for="flexRadioA<?=$row['QQId']?>">
                        A.<strong> <?=($row['ChoiceA']);?></strong>
                      </label>
                    </div>
        	  	</div>
        	  	<div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="form-check">
                      <input value="B" class="form-check-input" type="radio" name="flexRadioQ<?=$row['QQId']?>" id="flexRadioB<?=$row['QQId']?>" required="required">
                      <label class="form-check-label" for="flexRadioB<?=$row['QQId']?>">
                        B.<strong>  <?=($row['ChoiceB']);?></strong>
                      </label>
                    </div>
        	  	</div>
        	  	<div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="form-check">
                      <input value="C" class="form-check-input" type="radio" name="flexRadioQ<?=$row['QQId']?>" id="flexRadioC<?=$row['QQId']?>" required="required">
                      <label class="form-check-label" for="flexRadioC<?=$row['QQId']?>">
                        C.<strong>  <?=($row['ChoiceC']);?></strong>
                      </label>
                    </div>
        	  	</div>
        	  	<div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="form-check">
                      <input value="D" class="form-check-input" type="radio" name="flexRadioQ<?=$row['QQId']?>" id="flexRadioD<?=$row['QQId']?>" required="required">
                      <label class="form-check-label" for="flexRadioD<?=$row['QQId']?>">
                        D.<strong>  <?=($row['ChoiceD']);?></strong>
                      </label>
                    </div>
        	  	</div>
    	  	</div>
    	  	<?php $counte+=1; }
    	      }?>
     	  </div>
 		</form>    
    </div>        
<?php 
 require_once("views/footer.php");    
?>

 <script>
    $(document).ready(function() {
      var totalSeconds = 0;
      setInterval(setTime, 1000);

      function setTime() {
        ++totalSeconds;
        var minutes = Math.floor(totalSeconds / 60);
        var seconds = totalSeconds - minutes * 60;

        $('#timer').val(pad(minutes) + ":" + pad(seconds));
      }

      function pad(val) {
        var valString = val + "";
        if (valString.length < 2) {
          return "0" + valString;
        } else {
          return valString;
        }
      }
    });
  </script>