<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once('../PHPMailer/src/Exception.php');
require_once('../PHPMailer/src/PHPMailer.php');
require_once('../PHPMailer/src/SMTP.php');
require_once('../config.php');


// Read the form values
$success = false;
$senderName = isset( $_POST['username'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['username'] ) : null;
$senderPhone = isset( $_POST['phone'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['phone'] ) : null;
$senderEmail = isset( $_POST['email'] ) ? preg_replace( "/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email'] ) : null;
$subject = isset( $_POST['subject'] ) ? preg_replace( "/[^\s\S\.\-\_\@a-zA-Z0-9]/", "", $_POST['subject'] ) : null;
$message = isset( $_POST['message'] ) ? preg_replace( "/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message'] ) : null;

try {

        // If all values exist, send the email
        if ( $senderName && $senderEmail && $senderPhone && $subject && $message) {
          $recipient = RECIPIENT_NAME . " <" . RECIPIENT_EMAIL . ">";
          $headers = "From: " . $senderName . "";
          $msgBody = "Email: ". $senderEmail .  "\n\nPhone: ". $senderPhone . "\n\nSubject: ". $subject .  "\n\nMessage:\n" . $message . "";

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
        $mail->Host = HOST;
        $mail->Port = PORT;
        $mail->Username = USERNAME;
        $mail->Password = PASSWORD;
        
        $mail->CharSet = 'UTF-8';
        $mail->setFrom($senderEmail);
        $mail->Subject = $subject;
        $mail->Body = $msgBody;
        $mail->addAddress(RECIPIENT_EMAIL);
        
        $mail->send();

        echo "<script>alert('Your message has been sucessfully submitted Thanks. 🙂');</script>";
        echo "<script>document.location.href='index.html'</script>";
      }

    } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    echo "<script>alert('Mail was not Send');</script>";
    echo "<script>document.location.href='contact.html'</script>";
}


?>
