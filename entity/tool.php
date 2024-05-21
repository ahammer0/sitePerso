<?php
declare(strict_types=1);
require_once __DIR__ . "/../env.php";
require_once PROJROOT . "/entity/media.php";

class Tool
{
  private int $tech_id;
  private string $name;
  private Media $picture;
  private string $alt_seo;
  private string $url;
  private bool $is_enabled;

  public function __sleep()
  {
    return ["tech_id"];
  }
  public function __wakeup()
  {
    $this->updateAll();
  }
  public function getId(): int
  {
    return $this->tech_id;
  }
  public function getName(): string
  {
    return $this->name;
  }
  public function getAltSeo(): string
  {
    return $this->alt_seo;
  }
  public function getPicturePath(): string
  {
    return $this->picture->getAbsPath();
  }
  public function getPictureId(): int
  {
    return $this->picture->getId();
  }
  public function getUrl(): string
  {
    return $this->url;
  }
  public function getIsEnabled(): bool
  {
    return $this->is_enabled;
  }
  public function setAll(
    string $name,
    mixed $picture = 0,
    string $alt_seo,
    string $url,
    bool $is_enabled,
  ): void {
    if (is_numeric($picture)) {
      $picture = intval($picture);
    } else {
      throw new Exception(
        "picture id provided is not numeric :" . var_export($picture, true),
      );
    }
    require PROJROOT . "/dbConnect.php";
    if (isset($this->tech_id)) {
      $toolStatement = $db->prepare(
        "UPDATE technos SET name=:name, picture=:picture, alt_seo=:alt_seo, url=:url, is_enabled=:is_enabled WHERE tech_id=:tech_id",
      );
      $toolStatement->execute([
        "name" => $name,
        "picture" => $picture,
        "alt_seo" => $alt_seo,
        "url" => $url,
        "is_enabled" => $is_enabled ? 1 : 0,
        "tech_id" => $this->tech_id,
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
      $idTool = $db->prepare("SELECT @@identity");
      $idTool->execute();
      $this->tech_id = $idTool->fetch()[0];
    }
    $this->updateAll();
  }
  public function rm(): void
  {
    require PROJROOT . "/dbConnect.php";
    $rmStatement = $db->prepare("DELETE FROM technos WHERE tech_id=:tech_id");
    $rmStatement->execute(["tech_id" => $this->tech_id]);
  }
  public static function getAllEnabled(): array
  {
    require PROJROOT . "/dbConnect.php";
    $toolsStatement = $db->prepare(
      "SELECT tech_id FROM technos WHERE is_enabled=TRUE",
    );
    $toolsStatement->execute();
    $toolsId = $toolsStatement->fetchAll(PDO::FETCH_COLUMN);
    $toolsArray = array_map(function (int $index) {
      $tool = new Tool();
      $tool->setId($index);
      return $tool;
    }, $toolsId);
    return $toolsArray;
  }
  public function setId(mixed $id): void
  {
    if (!is_numeric($id)) {
      throw new Exception("the given id is not numeric");
    }
    $this->tech_id = intval($id);
    $this->updateAll();
  }
  private function updateAll(): void
  {
    // if we have an id, the entry have to exist
    require PROJROOT . "/dbConnect.php";
    $toolStatement = $db->prepare(
      "SELECT * FROM technos WHERE tech_id=:tech_id",
    );
    $toolStatement->execute([
      "tech_id" => $this->tech_id,
    ]);
    $tool = $toolStatement->fetch();
    if ($tool === false) {
      throw new Exception("the tool requested doesn't exist in database");
    } else {
      $this->name = $tool["name"];
      $this->picture = new Media();
      $this->picture->setId($tool["picture"]);
      $this->alt_seo = $tool["alt_seo"];
      $this->url = $tool["url"];
      $this->is_enabled = boolval($tool["is_enabled"]);
    }
  }
}
?>
