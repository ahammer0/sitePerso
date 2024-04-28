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
    <?php foreach ($tools as $tool): ?>
    <div class="sectionTools__container">
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
      </article>
    </div>
    <?php endforeach; ?>
  </section>
</body>
</html>
