<?php
session_start();

include("dbconn.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/htdocs/php1/register/src/Exception.php';
require 'C:/xampp/htdocs/php1/register/src/PHPMailer.php';
require 'C:/xampp/htdocs/php1/register/src/SMTP.php';

function send_password_reset($get_name,$get_email,$token){

    $mail = new PHPMailer(true);


    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
   
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->Username   = 'ns34547290@gmail.com';                     //SMTP username
    $mail->Password   = 'amybzytqqfckcxja';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('ns34547290@gmail.com', $get_name);
    $mail->addAddress($get_email);     
   

   
    $mail->isHTML(true);
    $mail->Subject = 'reset password notification';

    $email_template = "
    <h2> hello </h2>
    <h3> yu are receiving this email because we recieved password reset request from your account </h3>
    
    <br/><br/>
    <a href='http://localhost/php1/register/password-change.php?token=$token&email=$get_email'>click me</a>
    ";
    $mail->Body = $email_template;
    $mail->send();
   


}

if(isset($_POST['password_reset_link'])){
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $token = md5(rand());
    $check_email = "SELECT * FROM user WHERE email = '$email' LIMIT 1";
    $check_email_run = mysqli_query($conn,$check_email);
    if (mysqli_num_rows($check_email_run)>0) {
        $row = mysqli_fetch_array($check_email_run);
        $get_name = $row['name'];
        $get_email = $row['email'];
        $update_token= "UPDATE user SET verify_token = '$token' WHERE email = '$get_email' LIMIT 1  ";
        $update_token_run = mysqli_query($conn,$update_token);
        if ($update_token_run) {
            send_password_reset($get_name,$get_email,$token);
            $_SESSION['status'] = "we send you a password reset link";
            header("Location: password-reset.php");
            exit(0);
        }
        else {
            $_SESSION['status'] = "something went wrong";
            header("Location: password-reset.php");
            exit(0);
        }
    } 

    else{
        $_SESSION['status'] = "no email found";
        header("Location: password-reset.php");
        exit(0);
    }
}
if (isset($_POST['password_update'])) {
    $email = mysqli_real_escape_string($conn,$_POST['email']);   
    $new_password = mysqli_real_escape_string($conn,$_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn,$_POST['confirm_password']);
    $token = mysqli_real_escape_string($conn,$_POST['password_token']);
    if (!empty($token)) {
        if (!empty($email) && !empty($confirm_password) && !empty($new_password)) {
            $check_token =  "SELECT verify_token FROM user WHERE verify_token='$token' LIMIT 1 ";
            $check_token_run = mysqli_query($conn,$check_token);
            
            if (mysqli_num_rows($check_token_run)>0) {
                if ($new_password == $confirm_password) {
                    $update_password = "UPDATE user SET password='$new_password' WHERE verify_token='$token' LIMIT 1";
                    $update_password_run = mysqli_query($conn,$update_password);
                    if ($update_password_run) {
                        $_SESSION['status'] = "new password updated successfuly update";
                    header("Location: login.php");
                    exit(0);
                    }
                    else {
                        $_SESSION['status'] = "did not update password something went wrong";
                    header("Location: password-change.php?token=$token&email=$email");
                    exit(0);
                    }
                }
                else{
                    $_SESSION['status'] = "new password and confirm password not match";
                    header("Location: password-change.php?token=$token&email=$email");
                    exit(0); 
                }
            }
            else {
                $_SESSION['status'] = "invalid token";
                header("Location: password-change.php?token=$token&email=$email");
                exit(0); 
            }
        }
        else{
            $_SESSION['status'] = "all fields are mandatory";
            header("Location: password-change.php?token=$token&email=$email");
            exit(0); 
        }
    }
    else{
        $_SESSION['status'] = "no token available";
        header("Location: password-change.php");
        exit(0); 
    }



}


?>