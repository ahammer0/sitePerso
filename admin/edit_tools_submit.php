<?php
require_once __DIR__ . "/../dbConnect.php";

if (
  !isset($_POST) ||
  !isset($_POST["name"]) ||
  !isset($_POST["picture"]) ||
  !isset($_POST["alt_seo"]) ||
  !isset($_POST["url"])
) {
  echo "les données transmises ne sont pas conformes";
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
