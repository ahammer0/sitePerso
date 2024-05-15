<?php
require_once __DIR__ . "/../dbConnect.php";
require_once __DIR__ . "/../env.php";
require_once PROJROOT . "/entity/media.php";

session_start();
if (!isset($_SESSION["LOGGED_USER"])) {
  header("Location:login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE-edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Axel Schwindenhammer - Admin</title>
  <link rel="stylesheet" href="../style.css" />
</head>
<body>
        <header>
            <nav class="navbar">
                <img
                    src="../assets/icons/dev.png"
                    alt="logo developpeur web axel schwindenhammer"
                    class="navbar navbar__logo"
                />
                <h1>
                  Admin
                </h1>
                <div>
                  <h1>Utilisateur connecté :<?php echo $_SESSION["LOGGED_USER"][
                    "pseudo"
                  ]; ?></h1>
                  <form action="login_submit.php" method="post">
                    <input type="hidden" name="logout"/>
                    <button class="btn" type="submit">Déconnection</button>
                  </form>
                </div>
                <div class="navbar navbar__linkBlock">
                    <a class="navbar navbar__link" href="../">A Propos</a>
                    <a class="navbar navbar__link" href="../#work">Mon Travail</a>
                    <a class="navbar navbar__link" href="../#contact">Contact</a>
                </div>
            </nav>
        </header>
  <?php
  $toolsStatement = $db->prepare("SELECT * FROM technos");
  $toolsStatement->execute();
  $tools = $toolsStatement->fetchAll();
  ?>
  <section class="sectionTools">
    <h2>Section Tools</h2>
    <div class="sectionTools__container">
    <?php foreach ($tools as $tool):
      try {
        $picture = new Media();
        $picture->setId($tool["picture"]);
        $picturePath = $picture->getAbsPath();
      } catch (Exception $e) {
        $picturePath = "/assets/icons/dev.png";
      } ?>
      <article>
        <img
            class="sectionTools__img"
            src="<?php echo $picturePath; ?>"
            alt="<?php echo $tool["alt_seo"]; ?>"
            height="80"
            width="80"
        />
        <h3 class="sectionTools__title"><?php echo $tool["name"]; ?></h3>
        <div class="sectionTools__buttons">
          <form action="edit_tools.php" method="post">
            <input type="hidden" name="id" value="<?php echo $tool[
              "tech_id"
            ]; ?>">
            <button class="btn" type="submit">Éditer</button>
          </form>
          <form action="rm_tool.php" method="post">
            <input type="hidden" name="id" value="<?php echo $tool[
              "tech_id"
            ]; ?>">
            <button class="btn" type="submit">Supprimer</button>
          </form>
          <?php if ($tool["is_enabled"]): ?>
            <button class="btn btn--success" disabled>Activée</button>
        <?php endif; ?>
        </div>
      </article>
    <?php
    endforeach; ?>
    </div>
    <a href="edit_tools.php"><button class="btn">Créer une tool</button></a>
  </section>
  <section class="sectionWork" id="work">
  <?php
  $projectStatement = $db->prepare("SELECT * FROM projects");
  $projectStatement->execute();
  $projects = $projectStatement->fetchAll();
  ?>
      <h1 class="sectionWork__title">Mon Travail</h1>
      <div class="sectionWork__eltContainer">
      <?php foreach ($projects as $project):
        try {
          $picture = new Media();
          $picture->setId($project["picture"]);
          $picturePath = $picture->getAbsPath();
        } catch (Exception $e) {
          $picturePath = "/assets/icons/dev.png";
        } ?>
          <article class="workElt">
              <img
                  class="workElt__img"
                  src="<?php echo $picturePath; ?>"
                  alt="<?php echo $project[
                    "description_short"
                  ]; ?> fait par Axel Schwindenhammer"
              />
              <div class="workElt__content">
                  <h3 class="workElt__title">
                    <?php echo $project["name"]; ?>
                  </h3>
                  <p class="workElt__description">
                      <?php echo $project["description_short"]; ?>
                  </p>
                  <a class="workElt__link" href="<?php echo $project[
                    "url"
                  ]; ?>">
                  <?php echo $project["name"]; ?></a>
              </div>
              <div class="workElt__content">
                <form action="edit_project.php" method="post">
                  <input type="hidden" name="id" value="<?php echo $project[
                    "project_id"
                  ]; ?>">
                  <button class="btn" type="submit">Éditer</button>
                </form>
                <form action="rm_project.php" method="post">
                  <input type="hidden" name="id" value="<?php echo $project[
                    "project_id"
                  ]; ?>">
                  <button class="btn" type="submit">Supprimer</button>
                </form>
                <div>
                  <?php if ($project["is_enabled"]): ?>
                    <button class="btn btn--success" disabled>Activée</button>
                  <?php endif; ?>
                </div>
              </div>
          </article>
          <?php
      endforeach; ?>
      </div>
    <a href="edit_project.php"><button class="btn">Créer un projet</button></a>
  </section>
</body>
</html>
