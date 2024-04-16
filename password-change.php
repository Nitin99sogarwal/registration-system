<?php 
session_start();

$page_title = "password change ";

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
                <div class="card">
                    <div class="card-header">
                        <h5>change password</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="password-reset-code.php" method="POST">
                            <input type="hidden" name="password_token" value="<?php if (isset($_GET['token'])){echo $_GET['token'];}?> ">
                            <div class="form-group mb-3">
                                <label for="">Email</label>
                                <input type="text" name="email" value="<?php if (isset($_GET['email'])){echo $_GET['email'];}   ?> " class="form-control" placeholder="enter your email">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">New Password</label>
                                <input type="password" name="new_password" class="form-control" placeholder="enter new password">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="enter confirm password">
                            </div>                             
                            <div class="form-group">
                                <button type="submit" name ="password_update" class="btn btn-primary">Update password</button>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("include/footer.php") ?>