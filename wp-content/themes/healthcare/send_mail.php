<?php
use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';
function send_mail()  {
    //Create a new PHPMailer instance
    $mail = new PHPMailer;

//Tell PHPMailer to use SMTP
    $mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
    $mail->SMTPDebug = 2;

//Set the hostname of the mail server
    $mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
    $mail->Port = 465;

//Set the encryption system to use - ssl (deprecated) or tls
    $mail->SMTPSecure = 'ssl';

//Whether to use SMTP authentication
    $mail->SMTPAuth = true;

//Username to use for SMTP authentication - use full email address for gmail
    $mail->Username = "quangsang222@gmail.com";

//Password to use for SMTP authentication
    $mail->Password = "bcfwoolpqxznwaaa";

//Set who the message is to be sent from
    $mail->setFrom('quangsang222@gmail.com', 'Admin');

//Set an alternative reply-to address
    $mail->addReplyTo('quangsang222@gmail.com', 'Admin');

//Set who the message is to be sent to
    $mail->addAddress('quangsang222@gmail.com', 'Admin');

//Set the subject line
    $mail->Subject = 'From to: MyCv';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), __DIR__);

//Replace the plain text body with one created manually
    $mail->Body = 'Tên:'.$_POST['full_name'].
        '____, Email:'.$_POST['email'].
        '_____, Tin nhắn: '.$_POST['birthday'];

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        echo "Message sent!";
    }
}
