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


require_once("model/QuizModel.php");
$quizM=new QuizModel();
require_once 'model/TakeQuizModel.php';
$takeO=new TakeQuizModel();

require_once("views/header.php");
require_once("views/navi.php");
?>
<div class="container">
    <h3>Quizes you have taken</h3>
    <div class="table-responsive">
    	<table class="table">
          <thead>
            <tr>
              <th scope="col">Quiz#</th>
              <th scope="col">Subject(Topic)</th>
              <th scope="col">TotalItem</th>
              <th scope="col">Passing %</th>
              <th scope="col">TakenTimes</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php 
          $quizes=$quizM->getAllQuizesOfStudent($_SESSION["StudentId"]);
          if (!is_null($quizes)) {
              while ($row=$quizes->fetch_assoc()) { ?>                  
            <tr>
              <td><?=($row['QuizNo']);?></td>
              <td><?=($row['SubTopic']);?></td>
              <td><?=($row['TotalItems']);?></td>
              <td><?=($row['PercentagePassing']);?></td>
              <td><?=($row['TakenTimes']);?></td>
              <td><a data-bs-toggle="modal" data-bs-target="#quizModal<?=$row['QuizNo']?>" class="btn btn-sm btn-primary" href="#">View Scores</a>
              
               <!-- Modal -->
                            <div class="modal fade" id="quizModal<?=$row['QuizNo']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Quiz Details</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    	<div class="table-responsive ">
                                            <table class="table border table-sm table-hover">
                                              <thead>
                                                <tr>
                                                  <th scope="col">DateTaken</th>
                                                  <th scope="col">Your Total Score</th>
                                                  <th scope="col">Passing Score</th>
                                                  <th scope="col">Remarks</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                              <?php 
                                    $taken=$takeO->getAllTQStudent($_SESSION["StudentId"]);
                                    if (!is_null($taken)) {
                                        while ($rowT=$taken->fetch_assoc()) { ?>
                                                <tr>
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
              </td>
            </tr> 
         <?php }
          }          
          ?>
          </tbody>
        </table>
    </div>
</div>
<?php 
require_once("views/footer.php");    
?>