<?php
session_start();
require_once __DIR__ . "/../dbConnect.php";

if (!isset($_POST) || !isset($_POST["id"]) || !is_numeric($_POST["id"])) {
  echo "Les données transmises ne permettent pas de procéder";
  return;
}
if (
  !isset($_SESSION["LOGGED_USER"]) ||
  $_SESSION["LOGGED_USER"]["roles"] != "admin"
) {
  echo "Seuls les administrateurs peuvent enregistrer des données";
  header("Refresh:2;url=admin.php");
  return;
}
$id = $_POST["id"];
$toolStatement = $db->prepare("DELETE FROM technos WHERE tech_id=:tech_id");
$toolStatement->execute([
  "tech_id" => $id,
]);
header("Location:admin.php");
exit();
?>
