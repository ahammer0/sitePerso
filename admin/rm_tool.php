<?php
require_once __DIR__ . "/../dbConnect.php";
require_once PROJROOT . "/entity/tool.php";

if (!isset($_POST["id"]) || !is_numeric($_POST["id"])) {
  echo "Les données transmises ne permettent pas de procéder";
  return;
}
$id = $_POST["id"];
$tool = new Tool();
$tool->setId($id);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Suppression de <?php echo $tool->getName(); ?></title>
</head>
<body>
<h2>Voulez-vous vraiment supprimer <?php echo $tool->getName(); ?> ?</h2>
<form action="rm_tool_submit.php" method="post">
  <input type="hidden" name="id" value="<?php echo $tool->getId(); ?>"/>
  <button type="submit">Supprimer</button>
</form>
</body>
</html>
