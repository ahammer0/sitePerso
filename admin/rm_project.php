<?php
require_once __DIR__ . "/../dbConnect.php";

if (!isset($_POST["id"]) || !is_numeric($_POST["id"])) {
  echo "Les données transmises ne permettent pas de procéder";
  return;
}
$id = $_POST["id"];
$projectStatement = $db->prepare(
  "SELECT * FROM projects WHERE project_id=:project_id",
);
$projectStatement->execute([
  "project_id" => $id,
]);
$project = $projectStatement->fetch();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Suppression de <?php echo $project["name"]; ?></title>
</head>
<body>
<h2>Voulez-vous vraiment supprimer <?php echo $project["name"]; ?> ?</h2>
<form action="rm_project_submit.php" method="post">
  <input type="hidden" name="id" value="<?php echo $id; ?>"/>
  <button type="submit">Supprimer</button>
</form>
</body>
</html>
