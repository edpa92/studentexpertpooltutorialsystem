<?php
session_start();

if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}


require_once 'model/ProgressBasisModel.php';

$progM=new ProgressBasisModel();

require_once("views/header.php");
require_once("views/navi.php");
?>
<div class="container">
    <h3>Instructor Progress Basis</h3>
    <div class="p-3">
    		 
                <span><a class=" btn btn-primary float-end" href="ProgressBasisAdd.php"> Add new</a></span>
                         
    			<table class="table">
             		<thead>
             			<tr>
             				<th>Progress</th>
             				<th>Lower Limit - Higher Limit</th>
             				<th>Action</th>
             			</tr>
             		</thead>
             		<tbody>
             		<?php 
             		    $progbasises=$progM->getAllProgressBasis();
             		    if (!is_null($progbasises)) {
             		        while ($row=$progbasises->fetch_assoc()) {
             		        
             		?>
             			<tr>
                     		<td><?=($row['ProgressBasis']);?></td>
                     		<td><?=($row['LowerLimit']);?>% - <?=($row['HigherLimit']);?>%</td>
                     		<td><a href="ProgressBasisAdd.php?id=<?=($row['ProgressBasisId']);?>" class="btn btn-primary  btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a></td>
             			</tr>
             			<?php } }?>
             		</tbody>
             	</table>                
    		</div>
    
</div>
<?php 
require_once("views/footer.php");    
?>