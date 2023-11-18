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
					if ($mat['CategoryName']=="Videos") {?>								
        				<div class="ratio ratio-16x9">
        					<iframe width="560" height="315" src="<?=($mat['URL']);?>" ></iframe>
        				</div>
					<?php }else if ($mat['CategoryName']=="Docs/Sheets/Slides/PDF") {
					?>
						<h1 class="ratio ratio-16x9 border text-center py-4">
							<a target="_blank" class="icon-link" href="<?=($mat['URL']);?>">
    							<i class="bi bi-file-text-fill"></i>
    							<small>Files</small>
							</a>
						</h1>
					<?php }else if ($mat['CategoryName']=="Sites") {
					?>
						<h1 class="ratio ratio-16x9 border text-center py-4">
							<a target="_blank" class="icon-link" href="<?=($mat['URL']);?>">
    							<i class="bi bi-globe2"></i>
    							<small>Website</small>
							</a>
						</h1>
					<?php }else if ($mat['CategoryName']=="Images") {
					?>
						<h1 class="ratio ratio-16x9 border text-center py-4">
							<a target="_blank" class="icon-link" href="<?=($mat['URL']);?>">
    							<i class="bi bi-images"></i>
    							<small>Images</small>
    						</a>
						</h1>
					<?php }else if ($mat['CategoryName']=="Drive Folder") {
					?>
						<h1 class="border text-center py-4 ">
							<a target="_blank" class="icon-link text-center" href="<?=($mat['URL']);?>">
    							<i class="bi bi-folder2"></i>
    							<small>G-Drive Folder</small>
    						</a>
						</h1>
					<?php } ?>
							
					
			</div>
			<div class="col-sm-12 col-md-4 col-lg-6 ps-sm-4">
				<h4>			
					<a href="TestQuizAdd.php?m=<?=$id?>" class="btn btn-primary mt-1 me-2 float-end <?=($_SESSION["RoleSEPTS"] == "Instructor"?"d-inline":"d-none");?>">Add Quiz</a>
					
					<?=($mat['Title']);?>		
				</h4>
				<h6><?=($mat['Subject']." - ".$mat['TopicDescription']);?></h6>
				<em class=""><?=($mat['MaterialsDescription']);?></em>
				<a href="#">Lear more</a><br>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
			
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
                  $quizes=$qO->getAllQuiz($id);
                  if (!is_null($quizes)) {
                      while ($row=$quizes->fetch_assoc()) { ?>                         
                        <tr>
                          <td><?=$row['QuizNo']?></td>
                          <td><?=$row['DatePosted']?></td>
                          <td><?=$row['PercentagePassing']?>%</td>
                          <td><?=$row['TotalItem']?> points</td>
                          <td><?=$row['QCount']?> Question(s)</td>
                          <td><?=($row['Status']==0?"Inactive":"Active")?></td>
                          <td>
                          <a class="btn btn-primary <?=($_SESSION["RoleSEPTS"] == "Student"?"d-inline":"d-none");?>">Take the Quiz</a>
                          <a href="TestQuizAdd.php?m=<?=$id?>&q=<?=$row['QuizNo']?>" class="btn btn-primary btn-sm <?=($_SESSION["RoleSEPTS"] == "Instructor"?"d-inline":"d-none");?>">Edit</a></td>
                        </tr>
                    <?php   }
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
