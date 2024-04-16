<?php
session_start();
include("dbconn.php");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/htdocs/php1/register/src/Exception.php';
require 'C:/xampp/htdocs/php1/register/src/PHPMailer.php';
require 'C:/xampp/htdocs/php1/register/src/SMTP.php';

function sendemail_verify($name,$email,$verify_token){
  

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
    $mail->setFrom('ns34547290@gmail.com', $name);
    $mail->addAddress($email);     
   

   
    $mail->isHTML(true);
    $mail->Subject = 'email verificattion from nitin';

    $email_template = "
    <h2> you have registered </h2>
    <br/><br/>
    <a href='http://localhost/php1/register/verify-email.php?token=$verify_token'>click me</a>
    ";
    $mail->Body = $email_template;
    $mail->send();
    // echo 'Message has been sent';


}



if (isset($_POST['register_btn'])) {
    $name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm'];
$verify_token = md5(rand());
    $check_email_query = "SELECT email FROM user WHERE email ='$email' LIMIT 1";
    $check_email_query_run = mysqli_query($conn,$check_email_query);
    if(mysqli_num_rows($check_email_query_run) > 0 ){
        $_SESSION['status'] = 'email id already exists';
        header("Location: register.php");
    }
    else{
        $query = "INSERT INTO user (name,email,phone,password,verify_token) values ('$name','$email','$phone','$password','$verify_token')";
        $query_run = mysqli_query($conn,$query);    
        if ($query_run) {
            sendemail_verify("$name","$email","$verify_token");
            $_SESSION['status'] = "Registration Successfuly.! please verify your email address";
            header("Location: register.php");
        }
        else {
            $_SESSION['status'] = "Registration Failed";
            header("Location: register.php");
        }
    }
}

?>