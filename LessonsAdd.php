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
    
    
    require_once("model/SubjectModel.php");
    $sub=new SubjectModel();
    
    
    require_once("model/LessonModel.php");
    $lesObj=new LessonModel();
    $id=0;
    $les=null;
    if ($sub->isRequestPost()) {
        $topic=$sub->escapeString($_POST['topic']);
        $subid=$sub->escapeString($_POST['subid']);
        $status=$sub->escapeString($_POST['status']);
        $id=$sub->escapeString($_POST['id']);
        
        
        $result=$lesObj->addEdit($id, 
            $subid, 
            $topic, 
            $_SESSION["EmpIdCSHS"], 
            $status); 
        
        if ($result) {
            header("location: Lessons.php");
            exit();
        }
    }else {
        if (isset($_GET["id"]) && $_GET["id"]!="") {
            $id=$sub->escapeString($_GET["id"]);
            $les=$lesObj->get($id);
            if (is_null($les)) {
                header("location: 404.php");
                exit();
            }
        }
    }    
    
    require_once("views/header.php");
    require_once("views/navi.php");
?>
<div class="container">
    <h1>Add Lessons</h1>
    <div class="w-xl-50 w-lg-50 w-md-100 w-sm-100 w-100">
    <form method="post" class="row g-3">
    <input type="hidden" name="id" value="<?=$id?>">
      <div class="col-12">
        <label for="topic" class="form-label">Topic/Lesson:*</label>
        <input value="<?=(!is_null($les)?$les['TopicDescription']:"")?>" type="text" class="form-control" id="topic" name="topic" required="required">
      </div>

      <div class="col-md-6">
        <label for="subid" class="form-label">Subject:*</label>
        <select id="subid" name="subid" class="form-select" required="required">
          <option value="" selected>Choose...</option>
          <?php 
              $subO=$sub->getAllActiveSubject();
              if (!is_null($subO)) {
                  while ($row=$subO->fetch_assoc()) {
                      ?>                      
          		<option <?=(!is_null($les)&&$les['SubjectId']==$row["SubjectCode"]?"selected":"")?> value="<?=($row["SubjectCode"])?>"><?=($row["Subject"])?></option>
             <?php 
                  }
              }
          ?>
        </select>
      </div>
      <div class="col-md-6">
        <label for="status" class="form-label">Status:*</label>
        <select id="status" name="status" class="form-select" required="required">
          <option value="" selected>Choose...</option>
          <option <?=(!is_null($les)&&$les['Status']==1?"selected":"")?> value="1">Active</option>
          <option <?=(!is_null($les)&&$les['Status']==0?"selected":"")?> value="0">Inactive</option>
        </select>
      </div> 

      <div class="col-12">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
    </div>    
</div>
<?php 
require_once("views/footer.php");    
?>