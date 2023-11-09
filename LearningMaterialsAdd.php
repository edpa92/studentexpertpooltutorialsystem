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
    
    
    require_once("model/MaterialsModel.php");
    $mat=new MaterialsModel();

    $id=0;
    $matdata=NULL;
    if ($les->isRequestPost()) {
        $id=$les->escapeString($_POST["id"]);
       
        $mat->addEdit($id, 
            $les->escapeString($_POST['lesson']), 
            $les->escapeString($_POST['materialname']), 
            $les->escapeString($_POST['description']), 
            $les->escapeString($_POST['url']), 
            $les->escapeString($_POST['category']), 
            $les->escapeString($_POST['status']));
        
        
        header("location: LearningMaterials.php");
        exit();
    }else {
        if (isset($_GET['id'])&&$_GET['id']!="") {
            $id=$les->escapeString($_GET['id']);
            $matdata=$mat->get($id);
            if (is_null($matdata)) {
                header("location: 404.php");
                exit();
            }
        }
    }


require_once("views/header.php");
require_once("views/navi.php");
?>
<div class="container">
<div class="w-xl-50 w-lg-50 w-md-12 w-sm-12">
<h2>Add Learning Material</h2>
    <form method="post" class="row g-3">
    <input type="hidden" name="id" value="<?=$id?>">
      <div class="col-md-6">
        <label for="lesson" class="form-label">Topic/Lesson*:</label>
        <select id="lesson" name="lesson" class="form-select" required="required">
          <option value="" selected>Choose Topic/Lesson...</option>
          <?php 
          $dataLess=$les->getAllActive($_SESSION["EmpIdCSHS"]);
          if (!is_null($dataLess)) {
              while ($row=$dataLess->fetch_assoc()) {
              ?>
              	<option <?=($id>0&&$matdata['TopicId']==$row["TopicNo"]?"selected":"");?> value="<?=$row["TopicNo"]; ?>" ><?=$row["TopicDescription"]; ?> </option>
              <?php 
                  }
              }
          ?>
        </select>
      </div>
      <div class="col-md-6">
        <label for="category" class="form-label">Learning Materials Category*:</label>
        <select id="category" name="category" class="form-select" required="required">
          <option  value="" selected>Choose Category...</option>
          <?php 
              $cat=$mat->getAllCatogory();
              if (!is_null($cat)) {
                  while ($row=$cat->fetch_assoc()) {
              ?>
              	<option <?=($id>0&&$matdata['CategoryId']==$row["LMCatId"]?"selected":"");?> value="<?=$row["LMCatId"]; ?>" ><?=$row["CategoryName"]; ?> </option>
              <?php 
                  }
              }
          ?>
        </select>
      </div>      
      <div class="col-md-6">
        <label for="materialname" class="form-label">Material Name*:</label>
        <input value="<?=($id>0?$matdata['Title']:""); ?>" type="text" class="form-control" id="materialname" name="materialname" required="required">
      </div>
      <div class="col-md-4">
        <label for="status" class="form-label">Status*:</label>
        <select id="status" name="status" class="form-select" required="required">
          <option value="" selected>Choose...</option>
          <option <?=($id>0&&$matdata['Status']==1?"selected":"");?> value="1" >Active</option>
          <option <?=($id>0&&$matdata['Status']==0?"selected":"");?> value="0" >Inactive</option>
        </select>
      </div>
      <div class="col-12">
        <label for="description" class="form-label">Description*:</label>
        <input value="<?=($id>0?$matdata['MaterialsDescription']:""); ?>" type="text" class="form-control" id="description"  name="description" required="required">
      </div>
      <div class="col-12">
        <label for="url" class="form-label">URL*:</label>
        <input value="<?=($id>0?$matdata['URL']:""); ?>" type="text" class="form-control" id="url" name="url" placeholder="www.youtube.com" required="required">
      </div>
      <div class="col-12">
        <a href="LearningMaterials.php" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
    </div>
</div>
<?php 
require_once("views/footer.php");    
?>