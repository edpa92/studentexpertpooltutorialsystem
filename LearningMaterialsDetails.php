<?php
session_start();

    if (!isset($_SESSION["loggedinSEPTS"])) {
        header("location: login.php");
        exit();
    }
    
    
    require_once 'model/MaterialsModel.php';
    $matO=new MaterialsModel();
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
					if ($mat['CategoryName']!="Videos") {?>								
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
					<?php }else if ($mat['CategoryName']!="Drive Folder") {
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
					<a class="btn btn-primary mt-1 me-2 float-end">Take the Quiz</a>
					<?=($mat['Title']);?>		
				</h4>
				<h6><?=($mat['Subject']." - ".$mat['TopicDescription']);?></h6>
				<em class=""><?=($mat['MaterialsDescription']);?></em>
				<a href="#">Lear more</a><br>
			</div>
		</div>
    </div>
    
<?php 
require_once("views/footer.php");    
?>