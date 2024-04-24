<?php
try {
  $db = new PDO(
    "mysql:host=localhost:3306;dbname=ahammer;charset=utf8",
    "root",
    "",
  );
} catch (Exception $e) {
  die("Erreur : " . $e->getMessage());
}
?>
