<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Define some constants
define( "RECIPIENT_NAME", "info" );
define( "RECIPIENT_EMAIL", "info@medicalteameemsdelta.com" );

require_once('../PHPMailer/src/Exception.php');
require_once('../PHPMailer/src/PHPMailer.php');
require_once('../PHPMailer/src/SMTP.php');


// Read the form values
$success = false;
$senderName = isset( $_POST['username'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['username'] ) : "";
$senderPhone = isset( $_POST['phone'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['phone'] ) : "";
$senderEmail = isset( $_POST['email'] ) ? preg_replace( "/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email'] ) : "";
$subject = isset( $_POST['subject'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['subject'] ) : "";
$message = isset( $_POST['message'] ) ? preg_replace( "/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message'] ) : "";

try {

// If all values exist, send the email
if ( $senderName && $senderEmail && $senderPhone && $subject && $message) {
  $recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
  $headers = "From: " . $senderName . "";
  $msgBody = " Email: ". $senderEmail .  " Phone: ". $senderPhone . " Subject: ". $subject .  " Message: " . $message . "";

// changes start

$mail = new PHPMailer(true);
$mail->SMTPDebug = 0;   
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
// $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;    
$mail->SMTPOptions = array(
                     'ssl' => array(
                     'verify_peer' => false,
                     'verify_peer_name' => false,
                     'allow_self_signed' => true)
                     );
 $mail->Host = 'medicalteameemsdelta.com';
 $mail->Port = 465;
 $mail->Username = 'info@medicalteameemsdelta.com';
 $mail->Password = 'Qwerty.123+';
 $mail->setFrom($senderEmail);

 $mail->Subject = $headers;
 $mail->Body = $msgBody;
 $mail->CharSet = 'UTF-8';
 $mail->addAddress(RECIPIENT_EMAIL);
 
 $mail->send();
 
 //changes finish


  // $success = mail( $recipient, $headers, $msgBody );

  
echo "Mail has been sent successfully!";
echo "<script>alert('Your message has been sucessfully submitted Thanks. 🙂');</script>";
echo "<script>document.location.href='index.html'</script>";
}

} catch (Exception $e) {
  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  echo "<script>alert('Mail was not Send');</script>";
  echo "<script>document.location.href='contact.html'</script>";
}




?>