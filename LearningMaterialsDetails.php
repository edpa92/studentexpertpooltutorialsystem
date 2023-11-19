<?php
session_start();

    if (!isset($_SESSION["loggedinSEPTS"])) {
        header("location: login.php");
        exit();
    }
    
    
    require_once 'model/MaterialsModel.php';
    $matO=new MaterialsModel();
    
    
    require_once 'model/QuizModel.php';
    $qO=new QuizModel();
    
    
    require_once 'model/TakeQuizModel.php';
    $takeO=new TakeQuizModel();
    
    $id=0;
    $mat=null;
    
    if ($matO->isRequestPost()) {
        ;
    }else {        
        if (isset($_GET['id'])&&$_GET['id']!="") {
            $id=$_GET['id'];
            $mat=$matO->get($id);
            
            if (is_null($mat)) {
                header("location: 404.php");
                exit();
            }
        }else{            
            header("location: 404.php");
            exit();
        }
    }
   // https://www.youtube.com/embed/VIDEO_ID
require_once("views/header.php");
require_once("views/navi.php");
?>
    <div class="container">
		<div class="row pt-3">
			<div class="col-sm-12 col-md-8 col-lg-6">			
				<?php 
				if ($mat['Path']!=""&&!is_null($mat['Path'])) {
				    
				    $finfo = finfo_open(FILEINFO_MIME_TYPE);
				    $file_format = finfo_file($finfo, $mat['Path']);
				    finfo_close($finfo);
				    
				    //echo "The file format is: " . $file_format;
				    //video/mp4
				    //officedocument
				    //pdf
				    //image
				    
				    
				    if(strpos($file_format, "pdf")!==FALSE){?>				        
				      <div class="ratio ratio-16x9">
				        <iframe width="560" height="315" src="<?=($mat['Path']);?>" ></iframe>
				       </div>		
			 <?php }else if(strpos($file_format, "officedocument")!==FALSE){ ?>
				        <div class="text-center pt-4">
        					<a target="_blank" class="icon-link" href="<?=($mat['Path']);?>">    							
        						<h4><i class="bi bi-file-text-fill"></i> Download File</h4>
        					</a>
        				</div>
				 <?php  }else if(strpos($file_format, "video")!==FALSE){?>				        
				        <div class="ratio ratio-16x9">
				        <iframe width="560" height="315" src="<?=($mat['Path']);?>" ></iframe>
				        </div>		
				    <?php }else if(strpos($file_format, "image")!==FALSE){ ?>
				        <img src="<?=($mat['Path']);?>" class="img-fluid" alt="...">
				  <?php }
				    
				    
				}else {?>
				    <div class="text-center pt-4">
    				    <a title="<?=($mat['URL']);?>" target="_blank" class="icon-link" href="<?=($mat['URL']);?>">
    			        <h4><i class="bi bi-file-text-fill"></i><?=$mat['CategoryName'] ?>  Link </h4>
    			        </a>
			        </div>	
				<?php }?>	
					
			</div>
			<div class="col-sm-12 col-md-4 col-lg-6 ps-sm-4">
				<h4>			
					<a href="TestQuizAdd.php?m=<?=$id?>" class="btn btn-primary mt-1 me-2 float-end <?=($_SESSION["RoleSEPTS"] == "Instructor"?"d-inline":"d-none");?>">Add Quiz</a>		
					<a href="LearningMaterialsAdd.php?id=<?=$id?>" class="btn btn-primary mt-1 me-2 float-end <?=($_SESSION["RoleSEPTS"] == "Instructor"?"d-inline":"d-none");?>">Edit</a>
					
					<?=($mat['Title']);?>		
				</h4>
				<h6><?=($mat['Subject']." - ".$mat['TopicDescription']);?></h6>
				<em class=""><?=($mat['MaterialsDescription']);?></em>
				<a href="#">Lear more</a><br>
				<em class="float-end">Posted by:<?=($mat['FullNameIns']);?></em>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
			<?php 
			
			$student_id=$_SESSION["RoleSEPTS"] == "Student"?$_SESSION["StudentId"]:0;
			$quizes=$qO->getAllQuiz($id, $student_id);
			
			?>
			<h3>Quizes</h3>
			<div class="table-responsive">
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
                          <?php if($_SESSION["RoleSEPTS"] == "Student"&&$row['QCount']>0 && $row['Status']==1){?>
                          <a href="TakeQuiz.php?qid=<?=$row['QuizNo']?>" class="btn btn-primary ">Take Quiz</a>
                         <?php }?>
                         <?php if($_SESSION["RoleSEPTS"] == "Student" && $row['TakenByStudent']>0){?>
                          <a data-bs-toggle="modal" data-bs-target="#quizModal<?=$row['QuizNo']?>" href="#" class="btn btn-primary ">Details</a>
                         <?php }?>
                         
                          <a href="TestQuizAdd.php?m=<?=$id?>&q=<?=$row['QuizNo']?>" class="btn btn-primary btn-sm <?=($_SESSION["RoleSEPTS"] == "Instructor"?"d-inline":"d-none");?>">Edit</a>
                              <?php 
                            if ($_SESSION["RoleSEPTS"] == "Student"&&$row['TakenByStudent']>0) {
                        
                                  ?>                      
                            <!-- Modal -->
                            <div class="modal fade" id="quizModal<?=$row['QuizNo']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
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
                                                  <th scope="col">TotalScore</th>
                                                  <th scope="col">PassingScore</th>
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
                            <?php }?>
                          
                          </td>
                        </tr>
                        
                    <?php } }  }?>
                  </tbody>
                </table>
                
               
                </div>
                
			</div>
		</div>
    </div>
    
<?php 
require_once("views/footer.php");    
?>
