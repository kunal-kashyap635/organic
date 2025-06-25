<?php
require './phpmailer/Exception.php';
require './phpmailer/PHPMailer.php';
require './phpmailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function mailer($umsg,$to,$sub)
{
$mail = new PHPMailer(true);

try {
                        
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'example@gmail.com';                     
    $mail->Password   = "xxxxxxxxxxxxx";                               
               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
    $mail->Port       = 587;                                    

    $mail->setFrom('example@gmail.com', 'example');
    $mail->addAddress($to);    
    
    // $mail->addAttachment('./test.txt');     
    
    $mail->isHTML(true);                              
    $mail->Subject = $sub;
    $mail->Body  = $umsg;
    
    $mail->send();
    // echo 'Message has been sent';
    return true;
} catch (Exception $e) {
    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    return false;
}
}

?>
