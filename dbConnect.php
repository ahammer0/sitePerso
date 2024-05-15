<?php
require_once __DIR__ . "/env.php";
try {
  global $db;
  $db = new PDO(
    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
    DB_USER,
    DB_PASS,
  );
} catch (Exception $e) {
  die("Erreur : " . $e->getMessage());
}
?>
