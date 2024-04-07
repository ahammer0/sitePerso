<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);
$postData=$_POST;
$postPrenom=htmlspecialchars($postData['prenom']);
$postNom=htmlspecialchars($postData['nom']);
$postMessage=htmlspecialchars($postData['message']);
$postEmail=htmlspecialchars($postData['email']);

$subject='[ahammer.fr] Message de:'.$postPrenom.' '.$postNom;

try{
  $mail->SMTPDebug = SMTP::DEBUG_OFF;
  $mail->isSMTP();
  $mail->Host = 'smtp.mail.ovh.net';
  $mail->SMTPAuth = true;
  $mail->Username = 'axel@ahammer.fr';
  $mail->Password = '3N1I1AV950';
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $mail->Port = 465;

  $mail->setFrom('axel@ahammer.fr','Mailer ahammer.fr');
  $mail->addAddress('axel.schwindenhammer@gmail.com');
  $mail->addReplyTo($postEmail);

  $mail->isHTML(false);
  $mail->Subject = $subject;
  $mail->Body = $postMessage;

  $mail->send();
  echo 'message sent';
}catch (Exception $e){
  echo "message could not be send. error{$mail->ErrorInfo}";
}




?>



<a href="/index.php">retour a l' accueil</a>
