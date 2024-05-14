<?php
declare(strict_types=1);
require_once __DIR__ . "/../env.php";
require_once PROJROOT . "/debug.php";

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
    return $id;
  }
  public function getAbsPath(): string
  {
    return $absolutePath;
  }
  public function setId(int $id): void
  {
    $this->id = $id;
    $this->updateAll();
  }
  public function setAll(string $fileName, string $fileType): void
  {
    require PROJROOT . "/dbConnect.php";
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
        "INSERT INTO medias(filename,type) VALUES(:filename,:type)",
      );
      $mediaStatement->execute([
        "filename" => $fileName,
        "type" => $fileType,
      ]);
    }
    $this->updateAll();
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
    if ($media) {
      $this->fileName = $media["filename"];
      $this->fileType = $media["type"];
      $this->timesUsed = $media["times_used"];
      switch ($media["type"]) {
        case self::$allowedTypes[0]:
          $this->absolutePath = PROJROOT . "/media/icons/" . $media["filename"];
          break;
        case self::$allowedTypes[1]:
          $this->absolutePath =
            PROJROOT . "/media/projectPictures/" . $media["filename"];
          break;
        default:
          $this->absolutePath = null;
      }
    }
  }
}
?>
