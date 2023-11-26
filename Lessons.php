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

require_once("views/header.php");
require_once("views/navi.php");
?>
<div class="container">
    <h1>Lessons
    <a href="LessonsAdd.php" class="btn btn-primary float-end">Add new</a>
    </h1>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Topic#</th>
          <th scope="col">Description</th>
          <th scope="col">Subject</th>
          <th scope="col">Status</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>      
      <?php 
      $lesO=$les->getAll($_SESSION["EmpIdSEPTS"]);
	    if (!is_null($lesO)) {
	        while ($row=$lesO->fetch_assoc()) { ?> 
        <tr>
          <td scope="row"><?=$row['TopicNo']?></td>
          <td><?=$row['TopicDescription']?></td>
          <td><?=$row['Subject']?></td>
          <td><?=($row['Status']==0?"Inactive":"Active")?></td>
          <td><a class="btn btn-primary" href="LessonsAdd.php?id=<?=$row['TopicNo']?>">Edit</a></td>
        </tr>
	 <?php  }
	    }
	    ?>
      </tbody>
    </table>
</div>
<?php 
require_once("views/footer.php");    
?>