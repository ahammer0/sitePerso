<?php
session_start();
require_once __DIR__ . "/../dbConnect.php";
require_once PROJROOT . "/entity/tool.php";

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
$tool = new Tool();
$tool->setId($id);
$tool->rm();
header("Location:admin.php");
exit();
?>
