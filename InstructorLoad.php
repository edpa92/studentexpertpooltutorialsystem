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
    
    if ($ins->isRequestPost()) {
        $loadid=$ins->escapeString($_POST['loadid']);
        $ins->removeInsLoad($loadid);
    }
    
    require_once("views/header.php");
    require_once("views/navi.php");
    
?>
    <div class="container">
    	<h4>Class Sections Load </h4>
    	<small>These are the class section(s) that can view learning Materials you have posted.</small>        
        <a href="InstructorLoadAdd.php" class="btn btn-primary float-end">Add</a>
        <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Section</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
          <?php 
          $insLoad=$ins->getAllInsLoad($_SESSION["EmpIdSEPTS"]);
          if (!is_null($insLoad)) {
              while ($row=$insLoad->fetch_assoc()) { ?>                  
            <tr>
              <td ><?=($row['Section'])?></td>
              <td >
              <form method="post">
              	<input type="hidden" name="loadid" value="<?=($row['LoadId'])?>">
              <a class="btn btn-primary btn-sm m-1" href="StudentList.php?secid=<?=($row['SectionId'])?>">View Students</a>
              	<button type="submit" class="btn btn-primary btn-sm removeload">Remove</button>
              </form>
              </td>
            </tr>
     <?php  }
          }
          ?>
          </tbody>
        </table>
        </div>
    </div>
<?php 
require_once("views/footer.php");    
?>
<script>
	$(function(){		
		$(".removeload").click(function(){ return confirm("Are you sure?"); });
	});
</script>