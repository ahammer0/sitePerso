<?php
require_once __DIR__ . "/../dbConnect.php";

$toolStatement = $db->prepare("SELECT tech_id, name, picture FROM technos");
$toolStatement->execute();
$tools = $toolStatement->fetchAll();

if (isset($_POST) && isset($_POST["id"])) {

  if (!is_numeric($_POST["id"])) {
    echo ' l\'id transmis n\'est pas conforme';
    return;
  } else {
    $id = $_POST["id"];
  }
  $projectStatement = $db->prepare(
    "SELECT * FROM projects WHERE project_id=:project_id",
  );
  $projectStatement->execute([
    "project_id" => $id,
  ]);
  $project = $projectStatement->fetchAll()[0];
  ?>
<!--------- EDITION ------->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Édition du projet <?php echo $project["name"]; ?></title>
  <script src="tool_picker.js" defer ></script>
  <link rel="stylesheet" href="../style.css" />
</head>
<body>
<form action="edit_project_submit.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?php echo $_POST["id"]; ?>"/>
  <div>
    <label for="name">Nom du projet</label>
    <input type="text" name="name" value="<?php echo $project["name"]; ?>"/>
  </div>
  <div>
    <label for="picture">Nom du fichier icone</label>
    <input type="file" name="picture" />
    <input type="hidden" name="picture" value="<?php echo $project[
      "picture"
    ]; ?>"/>
  </div>
  <div>
    <label for="description">Description longue du projet</label>
    <textarea name="description" cols="30" rows="10"><?php echo $project[
      "description"
    ]; ?></textarea>
  </div>
  <div>
    <label for="description_short">Description courte du projet</label>
    <textarea name="description_short" cols="30" rows="10"><?php echo $project[
      "description_short"
    ]; ?></textarea>
  </div>
  <div>
    <label for ="url">Url du projet en ligne</label>
    <input type="url" name="url" value="<?php echo $project["url"]; ?>"/>
  </div>
  <div id="tool_picker">
    <input type="hidden" name="used_technos" value='<?php echo $project[
      "techs"
    ]; ?>'/>
    <input type="hidden" name="all_technos" value='<?php echo json_encode(
      $tools,
    ); ?>'/>
  </div>
  <div>
    <label for="is_enabled">Est visible ?</label>
    <input type="checkbox" name="is_enabled" value="1" <?php echo $project[
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
<!--------CREATION---->
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Création d'un projet</title>
  <link rel="stylesheet" href="../style.css" />
  <script src="tool_picker.js" defer ></script>
</head>
<body>
<form action="edit_project_submit.php" method="POST" enctype="multipart/form-data">
  <div>
    <label for="name">Nom du projet</label>
    <input type="text" name="name" />
  </div>
  <div>
    <label for="picture">Nom du fichier icone</label>
    <input type="file" name="picture"/>
    <input type="hidden" name="picture" value=""/>
  </div>
  <div>
    <label for="description">Description longue du projet</label>
    <textarea name="description" cols="30" rows="10"></textarea>
  </div>
  <div>
    <label for="description_short">Description courte du projet</label>
    <textarea name="description_short" cols="30" rows="10"></textarea>
  </div>
  <div>
    <label for ="url">Url du projet</label>
    <input type="url" name="url" />
  </div>
  <div id="tool_picker">
    <input type="hidden" name="used_technos" value="[]"/>
    <input type="hidden" name="all_technos" value='<?php echo json_encode(
      $tools,
    ); ?>'/>
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