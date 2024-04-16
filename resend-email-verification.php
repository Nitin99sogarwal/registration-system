<?php 
session_start();

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
                <div class="card">
                    <div class="card-header">
                        <h5> resend email verificaion</h5>
                    </div>
                    <div class="card-body">
                        <form action="resend-code.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="">Email Address</label>
                                <input type="text" name="email" placeholder="enter your email" class="form-control">
                            </div>                           
                            <div class="form-group">
                                <button type="submit" name ="resend_email_verify_btn" class="btn btn-primary">submit</button>
                            </div>
                        </form>
                       
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include("include/footer.php") ?>