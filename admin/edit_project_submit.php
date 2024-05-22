<?php
session_start();
require_once __DIR__ . "/../dbConnect.php";
require_once __DIR__ . "/../env.php";
require_once PROJROOT . "/entity/media.php";
require_once PROJROOT . "/entity/project.php";
require_once PROJROOT . "/entity/tool.php";

if (
  !isset($_POST) ||
  !isset($_POST["name"]) ||
  !isset($_POST["pictureId"]) ||
  !isset($_POST["description"]) ||
  !isset($_POST["description_short"]) ||
  !isset($_POST["url"]) ||
  !isset($_POST["used_technos"])
) {
  echo "les données transmises ne sont pas conformes";
  header("Refresh:3;url=admin.php");
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

$name = htmlspecialchars($_POST["name"]);
$pictureId = htmlspecialchars($_POST["pictureId"]);
$picture = new Media();
$picture->setId($pictureId);

$description = htmlspecialchars($_POST["description"]);
$description_short = htmlspecialchars($_POST["description_short"]);
$url = htmlspecialchars($_POST["url"]);

$usedTechnosJson = $_POST["used_technos"];
if (json_decode($usedTechnosJson) === null) {
  echo "le json des technos n' est pas valide";
  return;
}
$usedTechnos = array_map(function (mixed $elt) {
  $tool = new Tool();
  $tool->jsonLoad(json_encode($elt));
  return $tool;
}, json_decode($usedTechnosJson));

if (isset($_POST["id"]) && is_numeric($_POST["id"])) {
  $id = $_POST["id"];
  $isEditing = true;
} else {
  $isEditing = false;
}
if (isset($_POST["is_enabled"])) {
  $is_enabled = true;
} else {
  $is_enabled = false;
}

if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] == 0) {
  if ($_FILES["picture"]["size"] > 1000000) {
    echo "l' image est trop volumineuse";
    return;
  }
  $fileInfo = pathinfo($_FILES["picture"]["name"]);
  $extension = $fileInfo["extension"];
  $allowedExtensions = ["jpg", "jpeg", "gif", "png"];
  if (!in_array($extension, $allowedExtensions)) {
    echo "le fichier envoyé ne comporte pas une extension conforme <br/> l' extension {$extension} n' est pas autorisée";
    return;
  }
  $path = __DIR__ . "/../media/projectPictures/";
  if (!is_dir($path)) {
    echo "le dossier {$path} n' existe pas !";
    return;
  }

  /* uploaded file is ok, now we can save it */

  $file = new Media();
  $file->setAll($_FILES["picture"]["name"], "projectPicture");

  move_uploaded_file(
    $_FILES["picture"]["tmp_name"],
    PROJROOT . $file->getAbsPath(),
  );
  $picture = $file->getId();
}

if ($isEditing) {
  $toolStatement = $db->prepare(
    "UPDATE projects SET name=:name, picture=:picture, description=:description, description_short=:description_short, url=:url, is_enabled=:is_enabled, techs=:techs WHERE project_id=:project_id",
  );
  $toolStatement->execute([
    "name" => $name,
    "picture" => serialize($picture),
    "description" => $description,
    "description_short" => $description_short,
    "url" => $url,
    "is_enabled" => $is_enabled ? 1 : 0,
    "project_id" => $id,
    "techs" => serialize($usedTechnos),
  ]);
} else {
  $insertStatement = $db->prepare(
    "INSERT INTO projects (name,picture,description,description_short,url,is_enabled,techs) VALUES (:name,:picture,:description,:description_short,:url,:is_enabled,:techs)",
  );
  $insertStatement->execute([
    "name" => $name,
    "picture" => serialize($picture),
    "description" => $description,
    "description_short" => $description_short,
    "url" => $url,
    "is_enabled" => $is_enabled ? 1 : 0,
    "techs" => serialize($usedTechnos),
  ]);
}
echo "la requete à bien étée prise en compte";
header("Location:admin.php");
exit();
?>
