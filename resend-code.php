<?php
session_start();
include('dbconn.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'C:/xampp/htdocs/php1/register/src/Exception.php';
require 'C:/xampp/htdocs/php1/register/src/PHPMailer.php';
require 'C:/xampp/htdocs/php1/register/src/SMTP.php';

function resend_email_verify($name,$email,$verify_token){
    
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
$mail->Subject = 'resend email verificattion from nitin';

$email_template = "
<h2> you have registered </h2>
<br/><br/>
<a href='http://localhost/php1/register/verify-email.php?token=$verify_token'>click me</a>
";
$mail->Body = $email_template;
$mail->send();
// echo 'Message has been sent';


}
if (isset($_POST['resend_email_verify_btn'])) {
   if (!empty(trim($_POST['email']))) {
    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $checkemail_query = "SELECT * FROM user WHERE email = '$email' LIMIT 1 ";
    $checkemail_query_run = mysqli_query($conn,$checkemail_query);

    if (mysqli_num_rows($checkemail_query_run)>0) {

        $row = mysqli_fetch_array($checkemail_query_run);
        if($row['verify_status'] == "0"){
            $name = $row['name'];
            $email = $row['email'];
            $verify_token = $row['verify_token'];
            resend_email_verify($name,$email,$verify_token);
                $_SESSION['status'] = "verification email link has been sent to your email address";
                header("Location: login.php");
                exit(0);
            
        }
        else{
            $_SESSION['status'] = "email already verified please login karo";
        header("Location: resend-email-verification.php");
        exit(0);
        }
    }
    else {
        $_SESSION['status'] = "email is not register please register first";
        header("Location: register.php");
        exit(0);
    }
   }
   else{
    $_SESSION['status'] = "please enter the email field";
    header("Location: resend-email-verification.php");
    exit(0);
   }
}

?>