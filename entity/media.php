<?php
declare(strict_types=1);
require_once __DIR__ . "/../env.php";

class Media
{
  private int $id;
  private string $fileName;
  private string $fileType;
  private int $timesUsed;
  private string $absolutePath;
  private static $allowedTypes = ["icon", "projectPicture"];

  public function getId(): int
  {
    return $this->id;
  }
  public function getAbsPath(): string
  {
    return $this->absolutePath;
  }
  public static function getAllFromType(string $type): array
  {
    if (array_search($type, self::$allowedTypes) === false) {
      throw new Exception("type $type is not allowed");
    }
    require PROJROOT . "/dbConnect.php";
    $pictureListStatement = $db->prepare("
    SELECT id FROM medias WHERE type=:type");
    $pictureListStatement->execute(["type" => $type]);
    $pictureListId = $pictureListStatement->fetchAll(PDO::FETCH_COLUMN);
    $pictureArray = array_map(function (int $index) {
      $media = new Media();
      $media->setId($index);
      return $media;
    }, $pictureListId);
    return $pictureArray;
  }
  public static function getAllPathsFromType(string $type): array
  {
    $pictureArray = self::getAllFromType($type);
    $picturePaths = array_reduce(
      $pictureArray,
      function (array $acc, Media $icon) {
        $acc[$icon->getId()] = $icon->getAbsPath();
        return $acc;
      },
      [],
    );

    return $picturePaths;
  }

  public function setId(mixed $id): void
  {
    if (!is_numeric($id)) {
      throw new Exception("the given id is not numeric");
    }
    $this->id = intval($id);
    $this->updateAll();
  }
  public function setAll(string $fileName, string $fileType): void
  {
    if (array_search($fileType, self::$allowedTypes) === false) {
      throw new Exception("type $fileType is not allowed");
    }

    require PROJROOT . "/dbConnect.php";
    $fileName = self::getRndName($fileName);
    if (isset($this->id)) {
      $mediaStatement = $db->prepare(
        "UPDATE medias SET filename=:filename, type=:type WHERE id=:id",
      );
      $mediaStatement->execute([
        "filename" => $fileName,
        "type" => $fileType,
        "id" => $this->id,
      ]);
    } else {
      $mediaStatement = $db->prepare(
        "INSERT INTO medias(filename,type) VALUES(:filename,:type);",
      );
      $mediaStatement->execute([
        "filename" => $fileName,
        "type" => $fileType,
      ]);
      $idMedia = $db->prepare("SELECT @@identity");
      $idMedia->execute();
      $testid = $idMedia->fetch();
      $this->id = $testid[0];
    }
    $this->updateAll();
  }
  public function rm()
  {
    require PROJROOT . "/dbConnect.php";
    $rmStatement = $db->prepare("DELETE FROM media WHERE id=:id");
    $rmStatement->execute(["id" => $this->id]);
    $this->__destruct();
  }
  public static function getRndName(string $filename): string
  {
    $randStringLength = 30;
    $randString = "";
    for ($i = 0; $i < $randStringLength; $i++) {
      $randString .= chr(rand(ord("a"), ord("z")));
    }
    $randomisedName = basename(
      $randString . "." . pathinfo($filename, PATHINFO_EXTENSION),
    );
    /* check in db if name already exitst*/
    require PROJROOT . "/dbConnect.php";
    $filenameStatement = $db->prepare(
      "SELECT filename FROM medias WHERE filename=:filename",
    );
    $filenameStatement->execute(["filename" => $randomisedName]);
    if ($filenameStatement->fetch() != false) {
      $randomisedName = self::getRndName($randomisedName);
    }
    return $randomisedName;
  }
  private function updateAll(): void
  {
    /* if we have an id, the entry have to exist */
    require PROJROOT . "/dbConnect.php";
    $mediaStatement = $db->prepare("SELECT * FROM medias WHERE id=:id");
    $mediaStatement->execute([
      "id" => $this->id,
    ]);
    $media = $mediaStatement->fetch();
    /* test $media integrity and throw error if wrong*/
    if (!$media) {
      throw new Exception("the media requested doesn't exist in database");
    }
    if ($media) {
      $this->fileName = $media["filename"];
      $this->fileType = $media["type"];
      $this->timesUsed = $media["times_used"];
      switch ($media["type"]) {
        case self::$allowedTypes[0]:
          $this->absolutePath = "/media/icons/" . $media["filename"];
          break;
        case self::$allowedTypes[1]:
          $this->absolutePath = "/media/projectPictures/" . $media["filename"];
          break;
        default:
          echo "le type de fichier est erroné";
      }
    }
  }
}
?>
