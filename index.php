<?php
session_start();

if (!isset($_SESSION["loggedinSEPTS"])) {
    header("location: login.php");
    exit();
}

require_once("views/header.php");
require_once("views/navi.php");
?>
<div class="container">
    
</div>
<?php 
require_once("views/footer.php");    
?>