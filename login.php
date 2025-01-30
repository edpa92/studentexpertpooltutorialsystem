<?php 
session_start();

if (isset($_SESSION["loggedinSEPTS"])) {
    header("location: index.php");
    exit();
}

require_once("views/header.php");
require_once("views/navi.php");

require_once ('model/UserModel.php');
$user=new UserModel();
if ($user->isRequestPost()) {
    $result=$user->check_login($_POST['uname'],$_POST['password']);

    if (is_bool($result)&&$result) {
        header("location: index.php");
        exit();
    }
   
}

?>
<div class="container d-flex justify-content-center">

<form method="post" action="">
<?php 
if ($user->isRequestPost()) {
    echo "<div class='alert alert-danger'>".$result."</div>";
}
?>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Username</label>

    <input name="uname" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label><br>
    <div class="password-container  w-100">
    <input name="password" type="password" class="form-control w-100" id="exampleInputPassword1">
    <span class="toggle-password" id="toggle-password-hide">🫣</span>
    <span class="toggle-password" id="toggle-password-view">🤓</span>
    </div>
  </div>
  <div class="d-grid gap-2">
  <button type="submit" class="btn btn-primary">Login</button>
  <span>Need an account? You can Register <a href="Registration.php">here</a></span>
  </div>
</form>
</div>
<?php 
require_once("views/footer.php");    
?>y