<?php
require_once __DIR__ . "/../dbConnect.php";
require_once __DIR__ . "/../env.php";
require_once PROJROOT . "/entity/media.php";
require_once PROJROOT . "/entity/tool.php";

$pictureList = Media::getAllFromType("icon");

if (isset($_POST) && isset($_POST["id"])) {
  if (!is_numeric($_POST["id"])) {
    echo ' l\'id transmis n\'est pas conforme';
    return;
  } else {
    $id = $_POST["id"];
  }
  $tool = new Tool();
  $tool->setId($id);
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
      echo "Édition de la tool : " . $tool->getName();
    } else {
      echo "Création d' une tool";
    } ?>
  </title>
  <link rel="stylesheet" href="../style.css" />
</head>
<body class="">
  <div class="modalBox__background">
    <div class="modalBox">
      <h1 class="modalBox__element">
        <?php if ($isEdit) {
          echo "Édition de la tool : " . $tool->getName();
        } else {
          echo "Création d' une tool";
        } ?>
      </h1>
      <form class="form modalBox__element" action="edit_tools_submit.php" method="POST" enctype="multipart/form-data">
        <?php if (
          $isEdit
        ): ?><input type="hidden" name="id" value="<?php echo $_POST[
  "id"
]; ?>"/><?php endif; ?>
        <div class="form__item">
          <label for="name">Nom de la tool</label>
          <input class="input" type="text" name="name" value="<?php echo $isEdit
            ? $tool->getName()
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
          <input class="input" type="file" name="picture" />
          <input type="number" name="picture" value="<?php echo $isEdit
            ? $tool->getPictureId()
            : ""; ?>"/>
        </div>
        <div class="form__item">
          <label for="alt_seo">Description de l' icone</label>
          <input class="input" type="text" name="alt_seo" value="<?php echo $isEdit
            ? $tool->getAltSeo()
            : ""; ?>"/>
        </div>
        <div class="form__item">
          <label for ="url">Url de la techno</label>
          <input class="input" type="text" name="url" value="<?php echo $isEdit
            ? $tool->getUrl()
            : ""; ?>"/>
        </div>
        <div class="form__item">
          <label for="is_enabled">Est visible ?</label>
          <input type="checkbox" name="is_enabled" value="1" <?php echo $isEdit
            ? ($tool->getIsEnabled()
              ? "checked"
              : "")
            : ""; ?>/>
        </div>
        
        <button class="btn btn--success" type="submit">Valider</button>
        <a href="admin.php"><button class="btn">Annuler</button></a>
      </form>
    </div>
  </div>
</body>
</html>
