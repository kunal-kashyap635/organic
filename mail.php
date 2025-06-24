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
    $mail->Username   = 'kunalkash50@gmail.com';                     
    $mail->Password   = "nkjbjokcnstrhbco";                               
               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
    $mail->Port       = 587;                                    

    $mail->setFrom('kunalkash50@gmail.com', 'kunal');
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
