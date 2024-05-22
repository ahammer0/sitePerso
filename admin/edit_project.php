<?php
require_once __DIR__ . "/../dbConnect.php";
require_once __DIR__ . "/../env.php";
require_once PROJROOT . "/entity/media.php";
require_once PROJROOT . "/entity/tool.php";
require_once PROJROOT . "/entity/project.php";

$tools = Tool::getAll();
$pictureList = Media::getAllFromType("projectPicture");
$iconPaths = Media::getAllPathsFromType("icon");

if (isset($_POST) && isset($_POST["id"])) {
  if (!is_numeric($_POST["id"])) {
    echo ' l\'id transmis n\'est pas conforme';
    return;
  } else {
    $id = $_POST["id"];
  }
  $project = new Project();
  $project->setId($id);
  $isEdit = true;
} else {
  $isEdit = false;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE-edge" />
  <title>
    <?php if ($isEdit) {
      echo "Édition du projet : " . $project->getName();
    } else {
      echo "Création d'un projet";
    } ?>
  </title>
  <script src="tool_picker.js" defer ></script>
  <link rel="stylesheet" href="../style.css" />
</head>
<body class="">
<div class="modalBox__background">
  <div class="modalBox">
    <form class="form" action="edit_project_submit.php" method="POST" enctype="multipart/form-data">
      <?php if (
        $isEdit
      ): ?><input type="hidden" name="id" value="<?php echo $_POST[
  "id"
]; ?>"/><?php endif; ?>
      <div class="form__item">
        <label for="name">Nom du projet</label>
        <input type="text" name="name" value="<?php echo $isEdit
          ? $project->getName()
          : ""; ?>"/>
      </div>
      <div class="form__item">
        <div class="flex flex-row">
          <?php foreach ($pictureList as $picture): ?>
            <div>
              <img
                src="<?php echo $picture->getAbsPath(); ?>"
                width="30"
                height="30"/>
              <p><?php echo $picture->getId(); ?></p> 
            </div>
          <?php endforeach; ?>
        </div>
        <label for="picture">Nom du fichier icone</label>
        <input type="file" name="pictureId" />
        <input type="number" name="pictureId" value="<?php echo $isEdit
          ? $project->getPicture()->getId()
          : ""; ?>"/>
      </div>
      <div class="form__item">
        <label for="description">Description longue du projet</label>
        <textarea name="description" cols="30" rows="10"><?php echo $isEdit
          ? $project->getDescription()
          : ""; ?></textarea>
      </div>
      <div class="form__item">
        <label for="description_short">Description courte du projet</label>
        <textarea name="description_short" cols="30" rows="10"><?php echo $isEdit
          ? $project->getDescriptionShort()
          : ""; ?></textarea>
      </div>
      <div class="form__item">
        <label for ="url">Url du projet en ligne</label>
        <input type="url" name="url" value="<?php echo $isEdit
          ? $project->getUrl()
          : ""; ?>"/>
      </div>
      <div id="tool_picker" class="form__item">
      <?php vdump($project); ?>
        <input type="hidden" name="used_technos" value='<?php echo $isEdit
          ? json_encode($project->getTechs())
          : "[]"; ?>'/>
        <input type="hidden" name="all_technos" value='<?php echo json_encode(
          $tools,
        ); ?>'/>
      </div>
      <div class="form__item">
        <label for="is_enabled">Est visible ?</label>
        <input type="checkbox" name="is_enabled" value="1" <?php echo $isEdit
          ? ($project->getIsEnabled()
            ? "checked"
            : "")
          : ""; ?>/>
      </div>
      <button class="btn btn--success" type="submit">Valider</button>
      <a href="admin.php"><button type="button" class="btn">Annuler</button></a>
    </form>
  </div>
</div>
</body>
</html>
