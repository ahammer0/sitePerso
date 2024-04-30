<?php
require_once __DIR__ . "/../dbConnect.php";

if (!isset($_POST) || !isset($_POST["id"]) || !is_numeric($_POST["id"])) {
  echo "Les données transmises ne permettent pas de procéder";
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
