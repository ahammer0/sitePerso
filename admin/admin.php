<?php
require_once __DIR__ . "/../dbConnect.php"; ?>
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
  <?php
  $toolsStatement = $db->prepare("SELECT * FROM technos");
  $toolsStatement->execute();
  $tools = $toolsStatement->fetchAll();
  ?>
  <section class="sectionTools">
    <h2>Section Tools</h2>
    <div class="sectionTools__container">
    <?php foreach ($tools as $tool): ?>
      <article>
        <img
            class="sectionTools__img"
            src="./../assets/icons/<?php echo $tool["picture"]; ?>"
            alt="<?php echo $tool["alt_seo"]; ?>"
            height="80"
            width="80"
        />
        <h3 class="sectionTools__title"><?php echo $tool["name"]; ?></h3>
        <form action="edit_tools.php" method="post">
          <input type="hidden" name="id" value="<?php echo $tool[
            "tech_id"
          ]; ?>">
          <button type="submit">Éditer</button>
        </form>
        <form action="rm_tool.php" method="post">
          <input type="hidden" name="id" value="<?php echo $tool[
            "tech_id"
          ]; ?>">
          <button type="submit">Supprimer</button>
        </form>
        <?php if ($tool["is_enabled"]): ?>
          <div>Activée</div>
        <?php endif; ?>
      </article>
    <?php endforeach; ?>
    </div>
    <a href="edit_tools.php"><button>Créer une tool</button></a>
  </section>
  <section class="sectionWork" id="work">
  <?php
  $projectStatement = $db->prepare("SELECT * FROM projects");
  $projectStatement->execute();
  $projects = $projectStatement->fetchAll();
  ?>
      <h1 class="sectionWork__title">Mon Travail</h1>
      <div class="sectionWork__eltContainer">
      <?php foreach ($projects as $project): ?>
          <article class="workElt">
              <img
                  class="workElt__img"
                  src="../assets/images/<?php echo $project["picture"]; ?>"
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
              <form action="edit_project.php" method="post">
                <input type="hidden" name="id" value="<?php echo $project[
                  "project_id"
                ]; ?>">
                <button type="submit">Éditer</button>
              </form>
              <form action="rm_project.php" method="post">
                <input type="hidden" name="id" value="<?php echo $project[
                  "project_id"
                ]; ?>">
                <button type="submit">Supprimer</button>
              </form>
              <div><?php echo $project["is_enabled"] ? "activé" : ""; ?></div>
          </article>
          <?php endforeach; ?>
      </div>
    <a href="edit_project.php"><button>Créer un projet</button></a>
  </section>
</body>
</html>
