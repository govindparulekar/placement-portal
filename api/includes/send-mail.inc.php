<?php

include_once '../../PHPMailer/src/PHPMailer.php';
include_once '../../PHPMailer/src/Exception.php';
include_once '../../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

define("FROM","govindvp511@gmail.com");

function sendMail($from,$to,$sub,$body){
    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
                $mail->isSMTP();                                           
                $mail->Host       = 'smtp.gmail.com';                   
                $mail->SMTPAuth   = true;                                  
                $mail->Username   = "govindvp511@gmail.com";                    
                $mail->Password   = "mtnrzxeseiakwpgu";                          
                $mail->SMTPSecure = 'tls';  
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
                $mail->Port       = 587;

        //Recipients
        // setting from and to values
        $mail->setFrom($from);
        $mail->addAddress($to);    //Add a recipient

        //Content
        $mail->isHTML(false);                                  //Set email format to HTML
        $mail->Subject = $sub;
        $mail->Body    = $body;
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }

}
