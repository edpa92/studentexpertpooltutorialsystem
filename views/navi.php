<header class="p-3 mb-3 border-bottom bg-dark" data-bs-theme="dark">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        
        <strong class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
         SEPTS
        </strong>
<?php if (isset($_SESSION["loggedinSEPTS"])) {?>
        
        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <?php if($_SESSION["RoleSEPTS"]=="Admin"){
          ?>
          <li><a href="index.php" class="nav-link px-2 link-body-emphasis">Dashboard</a></li>
          <li><a href="UserManagment.php" class="nav-link px-2 link-body-emphasis">User Management</a></li>
          <li><a href="Setup.php" class="nav-link px-2 link-body-emphasis">System setup</a></li>
          <li><a href="ProgressBasis.php" class="nav-link px-2 link-body-emphasis">Progress Basis</a></li>
          <?php }?>
          
          <?php if($_SESSION["RoleSEPTS"]=="Instructor"){
              
              $current_url=$_SERVER["REQUEST_URI"];
              
          ?>
          <li><a href="index.php" class="nav-link px-2 link-body-emphasis">Dashboard</a></li>
          <li><a href="InstructorLoad.php" class="nav-link px-2 link-body-emphasis">Load</a></li>
          <li><a href="LearningMaterials.php" class="nav-link px-2 link-body-emphasis">Materials</a></li>
          <li><a href="Quizes.php" class="nav-link px-2 link-body-emphasis">Quizes</a></li>
          <li><a href="Lessons.php" class="nav-link px-2 link-body-emphasis">Lessons</a></li>
          <li class="<?=(strpos($current_url, "Chats.php")||strpos($current_url, "chats.php") !== false?"d-none":"")?>">        	 
             <div class="dropdown text-end">
              <a id="msg_menu" title="Unview/unopen Message" href="#" class="nav-link px-2 link-body-emphasis" data-bs-toggle="dropdown" aria-expanded="false">
             	Messages<span class="badge text-bg-danger" id="unread_span"><?=($_SESSION["unread_msg"]==0?"":$_SESSION["unread_msg"]); ?></span>
             </a>
              <ul id="messageul" class="dropdown-menu text-small">
                    <li><hr class="dropdown-divider"></li>
                   <li><a class="dropdown-item" href="Chats.php">See all</a></li>  
              </ul>
            </div>
         </li>
          <?php }?>
          
          <?php if($_SESSION["RoleSEPTS"]=="Student"){
              $current_url=$_SERVER["REQUEST_URI"];
             
          ?>
          <li><a href="index.php" class="nav-link px-2 link-body-emphasis">Home</a></li>
          <li><a href="StudentQuizes.php" class="nav-link px-2 link-body-emphasis">Quizes</a></li>
          <li class="<?=(strpos($current_url, "Chats.php")||strpos($current_url, "chats.php") !== false?"d-none":"")?>">        	 
             <div class="dropdown text-end">
              <a id="msg_menu" title="Unview/unopen Message" href="#" class="nav-link px-2 link-body-emphasis" data-bs-toggle="dropdown" aria-expanded="false">
             	Messages<span class="badge text-bg-danger" id="unread_span"><?=($_SESSION["unread_msg"]==0?"":$_SESSION["unread_msg"]); ?></span>
             </a>
              <ul id="messageul" class="dropdown-menu text-small ">  
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="Chats.php">See all</a></li>    
              </ul>
            </div>
        </li>
          <?php }?>
        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>
        

        <div class="dropdown text-end">
          <a href="#" class="d-block text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="<?=$_SESSION["PhotoSEPTS"];?>" alt="mdo" width="32" height="32" class="rounded-circle">
          <span>
          <?=$_SESSION["NameInSideBarSEPTS"];?>          
          </span>(<small><?=$_SESSION["RoleSEPTS"];?></small>)
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item <?=($_SESSION['RoleSEPTS']=='Admin'?'d-none':'');?>" href="<?=($_SESSION['RoleSEPTS']=='Instructor'?'InstructorProfile.php':'StudentProfile.php'); ?>">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
          </ul>
        </div>
        <?php }?>
        
      </div>
    </div>
  </header>