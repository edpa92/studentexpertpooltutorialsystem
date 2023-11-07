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
    <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-12">
                                <div class="p-5">
                                      <!-- 404 Error Text -->
                                        <div class="text-center">
                                            <h1 class="error mx-auto" data-text="404">404</h1>
                                            <h2 class="lead text-gray-800 mb-5">Page Not Found</h2>
                                            <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
                                            <a href="index.php">&larr; Back to Home</a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

</div>
<?php 
require_once("views/footer.php");    
?>