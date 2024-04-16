<?php 
include("authentication.php");
$page_title = "home page";
include("include/header.php");  
include("include/naavbar.php");
?>

<div class="py-5">
    <div class="container">
        <div class="row">
        <div class="col-md-12">
                    <?php
                        if (isset($_SESSION['status'])) {
                            ?>
                            <div class="alert alert-success">
                                <h5><?= $_SESSION['status']; ?></h5>
                            </div>
                            <?php
                            unset($_SESSION['status']);
                        }
                    ?>
           <div class="card-header">
                <h4>User dashboard</h4>
           </div>
           <div class="card-body">
                <h2>access with login</h2>
                <hr>
                <h5>username: <?= $_SESSION['auth_user']['username']; ?></h5>
                <h5>email: <?= $_SESSION['auth_user']['email']; ?></h5>
                <h5>phone: <?= $_SESSION['auth_user']['phone']; ?></h5>
           </div>
                    </div>
        </div>
    </div>
</div>


<?php include("include/footer.php") ?>