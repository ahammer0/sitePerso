<?php
require_once __DIR__ . "/../dbConnect.php";

if (!isset($_POST["id"]) || !is_numeric($_POST["id"])) {
  echo "Les données transmises ne permettent pas de procéder";
  return;
}
$id = $_POST["id"];
$toolStatement = $db->prepare("SELECT * FROM technos WHERE tech_id=:tech_id");
$toolStatement->execute([
  "tech_id" => $id,
]);
$tool = $toolStatement->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Suppression de <?php echo $tool["name"]; ?></title>
</head>
<body>
<h2>Voulez-vous vraiment supprimer <?php echo $tool["name"]; ?> ?</h2>
<form action="rm_tool_submit.php" method="post">
  <input type="hidden" name="id" value="<?php echo $id; ?>"/>
  <button type="submit">Supprimer</button>
</form>
</body>
</html>
