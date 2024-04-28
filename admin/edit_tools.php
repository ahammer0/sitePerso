<?php
require_once __DIR__ . "/../dbConnect.php";

if (isset($_POST) && isset($_POST["id"])) {

  if (!is_numeric($_POST["id"])) {
    echo ' l\'id transmis n\'est pas conforme';
    return;
  } else {
    $id = $_POST["id"];
  }
  $toolStatement = $db->prepare("SELECT * FROM technos WHERE tech_id=:tech_id");
  $toolStatement->execute([
    "tech_id" => $id,
  ]);
  $tool = $toolStatement->fetchAll()[0];
  ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Édition de la tool <?php echo $tool["name"]; ?></title>
</head>
<body>
<form action="edit_tools_submit.php" method="POST">
  <input type="hidden" name="id" value="<?php echo $_POST["id"]; ?>"/>
  <input type="text" name="name" value="<?php echo $tool["name"]; ?>"/>
  <input type="text" name="picture" value="<?php echo $tool["picture"]; ?>"/>
  <input type="text" name="alt_seo" value="<?php echo $tool["alt_seo"]; ?>"/>
  <input type="text" name="url" value="<?php echo $tool["url"]; ?>"/>
  <input type="checkbox" name="is_enabled" value="1" <?php echo $tool[
    "is_enabled"
  ]
    ? "checked"
    : ""; ?>/>
  
  <button type="submit">Valider</button>
</body>
</html>
<?php
}
?>
