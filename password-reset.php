<?php 
session_start();

$page_title = "password reset page";

include("include/header.php");  
include("include/naavbar.php");
?>
<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
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
                <div class="card shadow">
                    <div class="card-header">
                        <h5> Reset Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="password-reset-code.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Email</label>
                                <input type="text" name="email" class="form-control" placeholder="enter your email">
                            </div>
                                                      
                            <div class="form-group mb-3">
                                <button type="submit" name ="password_reset_link" class="btn btn-primary">send password reset link</button>
                            </div>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("include/footer.php") ?>