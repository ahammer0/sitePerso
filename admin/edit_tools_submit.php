<?php
session_start();
require_once __DIR__ . "/../dbConnect.php";

if (
  !isset($_POST) ||
  !isset($_POST["name"]) ||
  !isset($_POST["picture"]) ||
  !isset($_POST["alt_seo"]) ||
  !isset($_POST["url"])
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
$picture = htmlspecialchars($_POST["picture"]);
$alt_seo = htmlspecialchars($_POST["alt_seo"]);
$url = htmlspecialchars($_POST["url"]);
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
  $path = __DIR__ . "/../assets/icons/";
  if (!is_dir($path)) {
    echo "le dossier {$path} n' existe pas !";
    return;
  }
  move_uploaded_file(
    $_FILES["picture"]["tmp_name"],
    $path . basename($_FILES["picture"]["name"]),
  );
  $picture = basename($_FILES["picture"]["name"]);
}

if ($isEditing) {
  $toolStatement = $db->prepare(
    "UPDATE technos SET name=:name, picture=:picture, alt_seo=:alt_seo, url=:url, is_enabled=:is_enabled WHERE tech_id=:tech_id",
  );
  $toolStatement->execute([
    "name" => $name,
    "picture" => $picture,
    "alt_seo" => $alt_seo,
    "url" => $url,
    "is_enabled" => $is_enabled ? 1 : 0,
    "tech_id" => $id,
  ]);
} else {
  $insertStatement = $db->prepare(
    "INSERT INTO technos(name,picture,alt_seo,url,is_enabled) VALUES (:name, :picture, :alt_seo, :url, :is_enabled)",
  );
  $insertStatement->execute([
    "name" => $name,
    "picture" => $picture,
    "alt_seo" => $alt_seo,
    "url" => $url,
    "is_enabled" => $is_enabled ? 1 : 0,
  ]);
}
echo "la requete à bien étée prise en compte";
header("Location:admin.php");
exit();
?>
