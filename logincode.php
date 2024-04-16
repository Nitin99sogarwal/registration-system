<?php
session_start();
include("dbconn.php");
if (isset($_POST['login_now_btn'])) {

    if (!empty(trim($_POST['email'])) && !empty(trim($_POST['password']))) {
      
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $login_query = "SELECT * FROM user WHERE email='$email' AND password = '$password' LIMIT 1";
        $login_query_run = mysqli_query($conn,$login_query);
        if (mysqli_num_rows($login_query_run)>0) {
            $row = mysqli_fetch_array($login_query_run);
           
            if ($row['verify_status'] == "1") {
               $_SESSION['authenticated'] = TRUE;
               $_SESSION['auth_user'] = [
                'username' => $row['name'],
                'email' => $row['email'],
                'phone' => $row['phone']
               ];
               $_SESSION['status'] = "you login successful";
            header("Location: dashboard.php");
            exit(0);

            }
            else{
             $_SESSION['status'] = "please verify your email to login";
            header("Location: login.php");
            exit(0);   
            }
        }
        else{
            $_SESSION['status'] = "invalid email or password";
            header("Location: login.php");
            exit(0);
        }
    }
    else{
        $_SESSION['status'] = "all fields are manadatory";
        header("Location: login.php");
        exit(0);
    }


}


?>