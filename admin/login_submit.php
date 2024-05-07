<?php
session_start();
header("Refresh:3;url=login.php");
require_once __DIR__ . "/../dbConnect.php";

if (isset($_POST["logout"])) {
  session_destroy();
  header("Refresh:2;url=../index.php");
  echo "Déconnection...";
  return;
}
if (!isset($_POST) || !isset($_POST["login"]) || !isset($_POST["password"])) {
  echo "Les données reçues ne sont pas conformes";
  return;
}
$login = str_replace(" ", "", $_POST["login"]);
$password = str_replace(" ", "", $_POST["password"]);

if ($login == "" || $password == "") {
  echo "Le login ou le mot de passe est vide";
  return;
}
$userStatement = $db->prepare("SELECT * FROM users WHERE pseudo=:pseudo");
$userStatement->execute([
  "pseudo" => $login,
]);
$user = $userStatement->fetch();
if (!$user) {
  echo "Utilisateur non trouvé <br/>";
} else {
  if ($password == $user["password"]) {
    echo "Le mot de pass est bon<br/>";
    echo "Le role de {$user["pseudo"]} est : {$user["roles"]}<br/>";
    $_SESSION["LOGGED_USER"] = $user;
    header("Location:admin.php");
    exit();
  }
}
?>
