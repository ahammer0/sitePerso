<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . "/env.php";

//Load Composer's autoloader
require "vendor/autoload.php";

$mail = new PHPMailer(true);
$postData = $_POST;
$postPrenom = htmlspecialchars($postData["prenom"]);
$postNom = htmlspecialchars($postData["nom"]);
$postMessage = htmlspecialchars($postData["message"]);
$postEmail = htmlspecialchars($postData["email"]);

$subject = "[ahammer.fr] Message de:" . $postPrenom . " " . $postNom;

try {
  $mail->SMTPDebug = SMTP::DEBUG_OFF;
  $mail->isSMTP();
  $mail->Host = SMTP_HOST;
  $mail->SMTPAuth = true;
  $mail->Username = SMTP_USER;
  $mail->Password = SMTP_PASS;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $mail->Port = 465;

  $mail->setFrom(SMTP_USER, "Mailer ahammer.fr");
  $mail->addAddress(REDIRECT_EMAIL);
  $mail->addReplyTo($postEmail);

  $mail->isHTML(false);
  $mail->Subject = $subject;
  $mail->Body = $postMessage;

  $mail->send();
  echo "message sent";
  header("Refresh:2;url=./index.php");
} catch (Exception $e) {
  echo "message could not be send. error{$mail->ErrorInfo}";
}
?>



<a href="/index.php">retour a l' accueil</a>
