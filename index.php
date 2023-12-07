<?php
session_start();

if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}

    require_once 'model/SubjectModel.php';
    $subO=new SubjectModel();
    
    require_once 'model/MaterialsModel.php';
    $matO=new MaterialsModel();
    
    require_once 'model/InstructorModel.php';
    $insM=new InstructorModel();
    
    
    require_once 'model/SchoolYearModel.php';
    $syM=new SchoolYearModel();
    
    
    require_once 'model/QuizModel.php';
    $quizM=new QuizModel();
    
    
    require_once 'model/TakeQuizModel.php';
    $takequizM=new TakeQuizModel();
    
    
    
    
    
require_once("views/header.php");
require_once("views/navi.php");
?>

 <div class="container">
	<?php 
	if (isset($_SESSION["RoleSEPTS"]) && $_SESSION["RoleSEPTS"] == "Student") {
	    
	    if (isset($_SESSION["StudentClassSection"])&&$_SESSION["StudentClassSection"]>0) {
	    $subStud=$subO->getAllActiveSubjectOfStudent($_SESSION["StudentClassSection"]);
	    
	    if (!is_null($subStud)) {
	       while ($row=$subStud->fetch_assoc()) {
	           ?>
	    <div class="card mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><?=($row['Subject'])?> <small class="text-primary-emphasis float-end">Learning materials</small></h6>
            </div>
            <div class="card-body px-3 row flex-nowrap overflow-auto">
    	  		<?php 
    	  		    $mat=$matO->getAllMaterialsBySubjectforSection($row['SubjectCode'], $_SESSION["StudentClassSection"]);
    	  		    if (!is_null($mat)) {
    	  		        while ($rowM=$mat->fetch_assoc()) { if($rowM['Status']==1) {
    	  		            ?>    	  		               	  		             
                    <div class="card mx-2" style="width: 18rem;">
                      <div class="card-body">
                        <h5 class="card-title"><?=($rowM['Title']);?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><?=($rowM['TopicDescription']);?></h6>
                        
							<?php 
							if ($rowM['CategoryName']=="Videos") {?>
    							<h1 class=" border text-center py-5">
    								<i class="bi bi-play-circle-fill"></i>
    								<small>Video</small>
    							</h1>
							<?php }else if ($rowM['CategoryName']=="Docs/Sheets/Slides/PDF") {
							?>
								<h1 class=" border text-center py-5">
    								<i class="bi bi-file-text-fill"></i>
    								<small>Files</small>
    							</h1>
							<?php }else if ($rowM['CategoryName']=="Sites") {
							?>
								<h1 class=" border text-center py-5">
    								<i class="bi bi-globe2"></i>
    								<small>Website</small>
    							</h1>
							<?php }else if ($rowM['CategoryName']=="Images") {
							?>
								<h1 class=" border text-center py-5">
    								<i class="bi bi-images"></i>
    								<small>Image</small>
    							</h1>
							<?php }else if ($rowM['CategoryName']=="Google Drive Folder/File") {
							?>
								<h1 class=" border text-center py-5">
    								<i class="bi bi-folder2"></i>
    								<small>G-Drive Folder/Files</small>
    							</h1>
							<?php } ?>
							

						<a target="_blank" class='btn btn-outline-primary btn-sm p-auto' href="LearningMaterialsDetails.php?id=<?=($rowM['MaterialNo']);?>" class="card-link float-end">View</a>
						<small style="font-size: 10px;" class="text-secondary float-end">Posted by:<?=($rowM['Firstname']." ".$rowM['MI']." ".$rowM['Lastname']." ".$rowM['NameExt'])?></small>
						
                      </div>
                    </div>
              <?php  } }
    	  		    }else {    	  		        
    	  		        echo "<h4>No learning Materials Uploaded for this Subject.</h4>";
    	  		    }
    	  		?>       
            </div>
         </div>
	    
	      <?php }
	    }
	 }else {
   ?>
	  <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
	  		<h4 class="text-center">You did not register yet in a class section, Registere <a href="StudentProfile.php">here</a></h4>
        </div>
    </div>
	   <?php
        }
        
	}elseif (isset($_SESSION["RoleSEPTS"]) && $_SESSION["RoleSEPTS"] == "Instructor") { ?>
	
	<!-- Content Row -->
	<div class="container">
                    <div class="row">
                    	<div class="col-lg-12 p-2">
                        	<div class="dropdown w-100 mb-1">
                              <button class="btn btn-secondary dropdown-toggle dropend" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Select School Year to Generate Reports (SY)
                              </button>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="index.php">-- School Year --</a></li>
                                <?php 
                                    $sy=$syM->getAllSY();
                                    if (!is_null($sy)) {
                                        while ($rowsy=$sy->fetch_assoc()) {?>                                            
                               			 <li><a class="dropdown-item" href="index.php?sy=<?=($rowsy['SYCode']);?>">School Year: <?=($rowsy['YearStart']."-".$rowsy['YearEnd']);?></a></li>
                                 <?php  }
                                    }
                                ?>
                              </ul>
                            </div>                            	
                         </div>
                    <!-- Donut Chart -->
                        <div class="col-xl-4 col-lg-5">                        	
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Student Population<?php 
                                    $sy=$syM->getAllSY();
                                    if (!is_null($sy)) {
                                        while ($rowsy=$sy->fetch_assoc()) {?> 
                            			<em class="float-end <?=(isset($_GET['sy'])&&$_GET['sy']==$rowsy['SYCode']?"d-block":"d-none");?>"> SY: <?=($rowsy['YearStart']."-".$rowsy['YearEnd']);?></em>
                                     <?php  }
                                        }
                                    ?>                                    
                                    </h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <hr>
                                    # of Students per Class Section Load                                    
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8 col-lg-7">
                                    <!-- Bar Chart -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Per Sections Learning Tracker<?php 
                                    $sy=$syM->getAllSY();
                                    if (!is_null($sy)) {
                                        while ($rowsy=$sy->fetch_assoc()) { ?> 
                            			<em class="float-end <?=(isset($_GET['sy'])&&$_GET['sy']==$rowsy['SYCode']?"d-block":"d-none");?>"> SY: <?=($rowsy['YearStart']."-".$rowsy['YearEnd']); ?></em>
                                     <?php  }
                                        }
                                    ?>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-bar">
                                        <canvas id="myBarChart"></canvas>
                                    </div>
                                    <hr>
                                    For every Test/Quize you can view here the total combined score of every class section.
                                </div>
                            </div>
                            

                        </div>

                        
                </div>

      </div>
                <!-- /.container-fluid -->
			
		<script>
        	var pieData=[];
        	var pieLabel=[];
        	var pieBG=[];
        	var pieBGHover=[];
        	
        	  	
        	var quizesXLabel=[];
        	var datasets_data=[];
        	
        	
        	<?php 	
        	if (isset($_GET['sy'])&&$_GET['sy']!="") {          
        	    $piechart_data=$insM->generatePieChartReport($_SESSION["EmpIdSEPTS"], $_GET['sy']);
              if (!is_null($piechart_data)) {
              while ($rowPie=$piechart_data->fetch_assoc()) {
             ?>         
                	pieData.push('<?=($rowPie['StudCount']);?>');
                	pieLabel.push('<?=($rowPie['Section']);?>');
                	pieBG.push('<?=($insM->rand_color());?>');
                	pieBGHover.push('<?=($insM->rand_color());?>');
           <?php }
              }
              
              
              
              $linechart_data=$quizM->getAllQuizesForReport($_GET['sy'],$_SESSION["EmpIdSEPTS"]);
              if (!is_null($linechart_data)) {
                  while ($rowLine=$linechart_data->fetch_assoc()) { ?>                      
                      quizesXLabel.push("<?=("Quiz#".$rowLine['QuizNo']." ".$rowLine['TopicDescription']."(".$rowLine['Subject'].")");?>");
             <?php }
              } ?>
              var maxY=0;
              var newData = [
              <?php 
              $maxY=0;
              $inssec_load=$insM->getAllInsLoad($_SESSION["EmpIdSEPTS"]);
              if (!is_null($inssec_load)) {
                  while ($rowInsLoad=$inssec_load->fetch_assoc()) { 
                      $color=$insM->rand_color();
                  ?> 
                  {                  
                    label: "<?=($rowInsLoad['Section']);?>",
                    backgroundColor: '<?=($color);?>',
                    hoverBackgroundColor: '<?=($color);?>',
                    borderColor: '<?=($color);?>',
                    data: [<?php 
                    $linechart_data=$quizM->getAllQuizesForReport($_GET['sy'],$_SESSION["EmpIdSEPTS"]);
						if (!is_null($linechart_data)) {
						    while ($rowLine2=$linechart_data->fetch_assoc()) { 
						        $take=$takequizM->getAllSUMTOTALSCOREPERSEC($_GET['sy'], $rowLine2['QuizNo'], $rowInsLoad['Section']);
						        if (!is_null($take)) {
						            while ($rowline3=$take->fetch_assoc()) {
						                
						                $maxY=($maxY<$rowline3['SUMTOTALSCORESEC']?$rowline3['SUMTOTALSCORESEC']:$maxY); 
						                echo $rowline3['SUMTOTALSCORESEC'].','; 
						            } 
						        }else{ 
						            echo '0,'; 
						        }
						    }
                          } ?>],
                  },
              <?php }
              }
              ?>    
            ];
      		maxY=<?=($maxY);?>;
            for (var i = 0; i < newData.length; i++) {
              datasets_data.push(newData[i]);
            }      
 <?php } 
        	?>
        </script>	
  <?php }elseif (isset($_SESSION["RoleSEPTS"]) && $_SESSION["RoleSEPTS"] == "Admin") { ?>
	
	<!-- Content Row -->
	<div class="container">
                    <div class="row">
                    	<div class="col-lg-12 p-2">
                        	<div class="dropdown w-100 mb-1">
                              <button class="btn btn-secondary dropdown-toggle dropend" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Select School Year to Generate Reports (SY)
                              </button>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="index.php">-- School Year --</a></li>
                                <?php 
                                    $sy=$syM->getAllSY();
                                    if (!is_null($sy)) {
                                        while ($rowsy=$sy->fetch_assoc()) {?>                                            
                               			 <li><a class="dropdown-item" href="index.php?sy=<?=($rowsy['SYCode']);?>">School Year: <?=($rowsy['YearStart']."-".$rowsy['YearEnd']);?></a></li>
                                 <?php  }
                                    }
                                ?>
                              </ul>
                            </div>                            	
                         </div>
                    <!-- Donut Chart -->
                        <div class="col-xl-4 col-lg-5">                        	
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Student Population<?php 
                                    $sy=$syM->getAllSY();
                                    if (!is_null($sy)) {
                                        while ($rowsy=$sy->fetch_assoc()) {?> 
                            			<em class="float-end <?=(isset($_GET['sy'])&&$_GET['sy']==$rowsy['SYCode']?"d-block":"d-none");?>"> SY: <?=($rowsy['YearStart']."-".$rowsy['YearEnd']);?></em>
                                     <?php  }
                                        }
                                    ?>                                    
                                    </h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4">
                                        <canvas id="myPieChartAdmin"></canvas>
                                    </div>
                                    <hr>
                                    # of Students per Class Section                                
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-8 col-lg-7">
                                    <!-- Bar Chart -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Instructors Teaching Tracker<?php 
                                    $sy=$syM->getAllSY();
                                    if (!is_null($sy)) {
                                        while ($rowsy=$sy->fetch_assoc()) { ?> 
                            			<em class="float-end <?=(isset($_GET['sy'])&&$_GET['sy']==$rowsy['SYCode']?"d-block":"d-none");?>"> SY: <?=($rowsy['YearStart']."-".$rowsy['YearEnd']); ?></em>
                                     <?php  }
                                        }
                                    ?>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-bar">
                                        <canvas id="myBarChartAdmin"></canvas>
                                    </div>
                                    <hr>
                                    <p>For every Instructor you can view here the total number of load/posted/created Subjects, Topic, Quizes & Instructional Materials(IMs).</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 ">
                        	<div class="card shadow mb-4">
                              <div class="card-header">
                                Instructor Teaching Progresss
                              </div>
                              <div class="card-body">
                              
                        <?php if (isset($_GET['sy'])&&$_GET['sy']!="") {
                            ?>
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th style="width:25%">Instructor</th>
                                      <th style="width:75%">Progress</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  <?php 
                                      $ins=$insM->getAll();
                                      if (!is_null($ins)) {
                                          while ($rowIns=$ins->fetch_assoc()) { ?>                                      
                                    <tr>
                                      <td><?=($rowIns['Firstname'].' '.$rowIns['MI'].'. '.$rowIns['Lastname']);?></td>
                                      <td>
                                      <?php 
                                      $per=$insM->computeProgress($rowIns['EmpKey'],isset($_GET['sy'])&&$_GET['sy']!=""?$_GET['sy']:0);
                                      
                                      ?>
                                          <div style="height: 25px" class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="<?=($per->TotalPercentageProgress)?>" aria-valuemin="0" aria-valuemax="100">
                                              <div class="progress-bar progress-bar-striped progress-bar-animated overflow-visible text-dark" style="width: <?=($per->TotalPercentageProgress)?>%"><?=($per->TotalPercentageProgress)?>% - <?=($per->Progress)?> <?=($per->TotalStudPassers)?>Passers/<?=($per->TotalNumberOfStudent)?>Total Students</div>
                                        </div>
									  </td>
                                    </tr>
                                    <?php }
                                          } ?>
                                  </tbody>
                                </table>                                
                        	<?php }?>
                              </div>
                            </div>
                        </div>
                </div>

      </div>
                <!-- /.container-fluid -->
			
		<script>
        	var pieData=[];
        	var pieLabel=[];
        	var pieBG=[];
        	var pieBGHover=[];
        	
        	  	
        	var quizesXLabel=[];
        	var datasets_data=[];
        	
        	
        	<?php 	
        	if (isset($_GET['sy'])&&$_GET['sy']!="") {          
        	    $piechart_data=$insM->generatePieChartReport(0, $_GET['sy']);
              if (!is_null($piechart_data)) {
              while ($rowPie=$piechart_data->fetch_assoc()) {
             ?>         
                	pieData.push('<?=($rowPie['StudCount']);?>');
                	pieLabel.push('<?=($rowPie['Section']);?>');
                	pieBG.push('<?=($insM->rand_color());?>');
                	pieBGHover.push('<?=($insM->rand_color());?>');
           <?php }
              }
              
              
              
              $barXLabel_data=$insM->getAll();
              if (!is_null($barXLabel_data)) {
                  while ($rowLine=$barXLabel_data->fetch_assoc()) { ?>                      
                      quizesXLabel.push("<?=($rowLine['EmpId']."-".$rowLine['Firstname']." ".$rowLine['MI']." ".$rowLine['Lastname']);?>");
             <?php }
              } ?>
              
              
              var maxY=0;
              
              var colorSubject='<?=($insM->rand_color());?>';
              var colorTopic='<?=($insM->rand_color());?>';
              var colorQuiz='<?=($insM->rand_color());?>';
              var colorIMS='<?=($insM->rand_color());?>';
              
              var newData = [
              <?php 
              $maxY=0; ?>
             
                  {                  
                    label: "Subject",
                    backgroundColor: colorSubject,
                    hoverBackgroundColor: colorSubject,
                    borderColor: colorSubject,
                    data: [<?php $barXLabel_data=$insM->getAll();
                          if (!is_null($barXLabel_data)) {
                              while ($rowSUb=$barXLabel_data->fetch_assoc()) { 
                                  $subCount=$insM->countSubOfIns($rowSUb['EmpKey']);
                                  echo $subCount.',';
                              }
                          } ?>],
                  },
                  
                  {                  
                    label: "Topic",
                    backgroundColor: colorTopic,
                    hoverBackgroundColor: colorTopic,
                    borderColor: colorTopic,
                    data: [<?php $barXLabel_data=$insM->getAll();
                          if (!is_null($barXLabel_data)) {
                              while ($rowSUb=$barXLabel_data->fetch_assoc()) { 
                                  $Count=$insM->countTopicOfIns($rowSUb['EmpKey']);
                                  echo $Count.',';
                              }
                          } ?>],
                  },
                  
                  {                  
                    label: "Quizes",
                    backgroundColor: colorQuiz,
                    hoverBackgroundColor: colorQuiz,
                    borderColor: colorQuiz,
                    data: [<?php $barXLabel_data=$insM->getAll();
                          if (!is_null($barXLabel_data)) {
                              while ($rowSUb=$barXLabel_data->fetch_assoc()) { 
                                  $Count=$insM->countQuizOfIns($rowSUb['EmpKey']);
                                  echo $Count.',';
                              }
                          } ?>],
                  },                  
                  {                  
                    label: "IMs",
                    backgroundColor: colorIMS,
                    hoverBackgroundColor: colorIMS,
                    borderColor: colorIMS,
                    data: [<?php $barXLabel_data=$insM->getAll();
                          if (!is_null($barXLabel_data)) {
                              while ($rowSUb=$barXLabel_data->fetch_assoc()) { 
                                  $Count=$insM->countMaterialsOfIns($rowSUb['EmpKey']);
                                  echo $Count.',';
                              }
                          } ?>],
                  },
                 
            ];
            
              		maxY=<?=($maxY);?>;
                    for (var i = 0; i < newData.length; i++) {
                      datasets_data.push(newData[i]);
                    }      
       <?php } 
        	?>
        </script>	
<?php }?>
  
  
  
 </div>
<?php 
require_once("views/footer.php");    
?>