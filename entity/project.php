<?php
declare(strict_types=1);
require_once __DIR__ . "/../env.php";
require_once PROJROOT . "/entity/media.php";
require_once PROJROOT . "/entity/tool.php";

class Project
{
  private int $project_id;
  private string $name;
  private string $description;
  private string $description_short;
  private Media $picture;
  private string $url;
  private array $techs;
  private bool $is_enabled;

  public function getTechs(): array
  {
    return $this->techs;
  }

  public function getDescription(): string
  {
    return $this->description;
  }

  public function getId(): int
  {
    return $this->project_id;
  }

  public function getIsEnabled(): bool
  {
    return $this->is_enabled;
  }

  public function getPicture(): Media
  {
    return $this->picture;
  }

  public function getDescriptionShort(): string
  {
    return $this->description_short;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getUrl(): string
  {
    return $this->url;
  }

  public static function get3Enabled(): array
  {
    require PROJROOT . "/dbConnect.php";
    $projectStatement = $db->prepare(
      "SELECT project_id FROM projects WHERE is_enabled=TRUE ORDER BY project_id DESC LIMIT 3",
    );
    $projectStatement->execute();
    $projectsId = $projectStatement->fetchAll(PDO::FETCH_COLUMN);
    $projectsArray = array_map(function (int $index) {
      $project = new Project();
      $project->setId($index);
      return $project;
    }, $projectsId);
    return $projectsArray;
  }

  public static function getAllEnabled(): array
  {
    require PROJROOT . "/dbConnect.php";
    $projectStatement = $db->prepare(
      "SELECT project_id FROM projects WHERE is_enabled=TRUE ORDER BY project_id ",
    );
    $projectStatement->execute();
    $projectsId = $projectStatement->fetchAll(PDO::FETCH_COLUMN);
    $projectsArray = array_map(function (int $index) {
      $project = new Project();
      $project->setId($index);
      return $project;
    }, $projectsId);
    return $projectsArray;
  }

  public static function getAll(): array
  {
    require PROJROOT . "/dbConnect.php";
    $projectStatement = $db->prepare(
      "SELECT project_id FROM projects ORDER BY project_id ",
    );
    $projectStatement->execute();
    $projectsId = $projectStatement->fetchAll(PDO::FETCH_COLUMN);
    $projectsArray = array_map(function (int $index) {
      $project = new Project();
      $project->setId($index);
      return $project;
    }, $projectsId);
    return $projectsArray;
  }
  public function setId(mixed $id): void
  {
    if (!is_numeric($id)) {
      throw new Exception("the given id is not numeric");
    }
    $this->project_id = intval($id);
    $this->updateAll();
  }
  private function updateAll(): void
  {
    // if we have an id, the entry have to exist
    require PROJROOT . "/dbConnect.php";
    $projectStatement = $db->prepare(
      "SELECT * FROM projects WHERE project_id=:project_id",
    );
    $projectStatement->execute([
      "project_id" => $this->project_id,
    ]);
    $project = $projectStatement->fetch();
    if ($project === false) {
      throw new Exception("the project requested doesn't exist in database");
    } else {
      $this->name = $project["name"];
      $this->description = $project["description"];
      $this->description_short = $project["description_short"];

      $unserializedPicture = unserialize($project["picture"]);
      if ($unserializedPicture !== false) {
        $this->picture = $unserializedPicture;
      } else {
        $this->picture = new Media();
        $this->picture->setId(1);
      }

      $this->url = $project["url"];
      $unserializedTechs = unserialize($project["techs"]);
      if ($unserializedTechs !== false) {
        $this->techs = $unserializedTechs;
      } else {
        $newTool = new Tool();
        $newTool->setId(1);
        $this->techs = [$newTool];
      }
      $this->is_enabled = boolval($project["is_enabled"]);
    }
  }
  public function setAll(
    string $name,
    string $description,
    string $description_short,
    mixed $picture,
    string $url,
    array $techs,
    bool $is_enabled,
  ): void {
    if (is_numeric($picture)) {
      $picture = intval($picture);
    } else {
      throw new Exception(
        "picture id provided is not numeric : " . var_export($picture, true),
      );
    }
    require PROJROOT . "/dbConnect.php";
    if (isset($this->project_id)) {
      /* $projectStatement = $db->prepare( */
      /*   "SELECT name, description_short, picture, url, project_id FROM projects WHERE is_enabled=TRUE ORDER BY project_id DESC LIMIT 3", */
      /* ); */
      /* $projectStatement->execute(); */
      /* $projects = $projectStatement->fetchAll(); */
    }
  }
}
