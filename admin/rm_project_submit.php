<?php
require_once __DIR__ . "/../dbConnect.php";

if (!isset($_POST) || !isset($_POST["id"]) || !is_numeric($_POST["id"])) {
  echo "Les données transmises ne permettent pas de procéder";
  return;
}
$id = $_POST["id"];
$projectStatement = $db->prepare(
  "DELETE FROM projects WHERE project_id=:project_id",
);
$projectStatement->execute([
  "project_id" => $id,
]);
header("Location:admin.php");
exit();
?>
