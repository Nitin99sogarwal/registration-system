<?php 
session_start();
if (isset($_SESSION['authenticated'])) {
            $_SESSION['status'] = "you are already login ";
            header("Location: dashboard.php");
            exit(0);
}

$page_title = "login page";

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
                        <h5> Login form</h5>
                    </div>
                    <div class="card-body">
                        <form action="logincode.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Email</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>                            
                            <div class="form-group">
                                <button type="submit" name ="login_now_btn" class="btn btn-primary">Login</button>
                                <a href="password-reset.php" class="float-end">forget your password ?</a>
                            </div>
                        </form>
                        <h5>
                            did not recieve your email verificattion ?
                            <a href="resend-email-verification.php">Resend</a>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("include/footer.php") ?>