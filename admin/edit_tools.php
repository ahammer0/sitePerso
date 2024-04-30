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
<form action="edit_tools_submit.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?php echo $_POST["id"]; ?>"/>
  <div>
    <label for="name">Nom de la tool</label>
    <input type="text" name="name" value="<?php echo $tool["name"]; ?>"/>
  </div>
  <div>
    <label for="picture">Nom du fichier icone</label>
    <input type="file" name="picture" />
    <input type="hidden" name="picture" value="<?php echo $tool[
      "picture"
    ]; ?>"/>
  </div>
  <div>
    <label for="alt_seo">Description de l' icone</label>
    <input type="text" name="alt_seo" value="<?php echo $tool["alt_seo"]; ?>"/>
  </div>
  <div>
    <label for ="url">Url de la techno</label>
    <input type="text" name="url" value="<?php echo $tool["url"]; ?>"/>
  </div>
  <div>
    <label for="is_enabled">Est visible ?</label>
    <input type="checkbox" name="is_enabled" value="1" <?php echo $tool[
      "is_enabled"
    ]
      ? "checked"
      : ""; ?>/>
  </div>
  
  <button type="submit">Valider</button>
</body>
</html>

<?php
} else {
   ?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Création d' une tool</title>
</head>
<body>
<form action="edit_tools_submit.php" method="POST" enctype="multipart/form-data">
  <div>
    <label for="name">Nom de la tool</label>
    <input type="text" name="name" />
  </div>
  <div>
    <label for="picture">Nom du fichier icone</label>
    <input type="file" name="picture"/>
    <input type="hidden" name="picture" value=""/>
  </div>
  <div>
    <label for="alt_seo">Description de l' icone</label>
    <input type="text" name="alt_seo" />
  </div>
  <div>
    <label for ="url">Url de la techno</label>
    <input type="text" name="url" />
  </div>
  <div>
    <label for="is_enabled">Est visible ?</label>
    <input type="checkbox" name="is_enabled" value="1"/>
  </div>
  
  <button type="submit">Valider</button>
</body>
</html>
<?php
}
?>
