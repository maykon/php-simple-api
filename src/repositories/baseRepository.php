<?php
require_once __DIR__ . "/../meta/attributes.php";
require_once __DIR__ . "/../models/entity.php";

class Repository
{
  protected $connection = null;

  public function __construct()
  {
    $dbHost = getenv('DB_HOST');
    $dbName = getenv('DB_NAME');
    $dbUser = getenv('DB_USER');
    $pwFilePath = getenv('PASSWORD_FILE_PATH');
    $dbPass = trim(file_get_contents($pwFilePath));

    $this->connection = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
  }

  public function __destruct()
  {
    $this->connection = null;
  }

  public function getConnection()
  {
    return $this->connection;
  }

  public function executeSQL(string $query, array $params = []): PDOStatement|bool
  {
    $stmt = $this->connection->prepare($query);
    $stmt->execute($params);
    return $stmt;
  }

  public function queryAll(string $query, array $params = []): array
  {
    $stmt = $this->executeSQL($query, $params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function queryOne(string $query, array $params = []): array
  {
    $stmt = $this->executeSQL($query, $params);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result : [];
  }

  public function createSQL(string $query, array $params = []): int
  {
    $this->executeSQL($query, $params);
    return $this->connection->lastInsertId();
  }

  public function getEntityName(): string
  {
    try {
      $entityClass = new ReflectionClass(static::class);
      [$entity] = $entityClass->getAttributes(EntityName::class);
      $instance = $entity->newInstance();
      return $instance->entityName;
    } catch (ReflectionException $e) {
      return static::class;
    }
  }

  public function getTableName(): string
  {
    try {
      $entityClass = new ReflectionClass($this->getEntityName());
      return $entityClass->getMethod("tableName")->invoke($this);
    } catch (ReflectionException $e) {
      return $this->getEntityName();
    }
  }

  public function getProperties(): array
  {
    $entityClass = new ReflectionClass($this->getEntityName());
    $properties = $entityClass->getProperties(ReflectionProperty::IS_PUBLIC);
    return array_map(fn($prop) => $prop->getName(), $properties);
  }

  public function findAll(): array
  {
    $tableName = $this->getTableName();
    $query = "SELECT * from $tableName";
    return $this->queryAll($query);
  }

  public function findById(int $id): array
  {
    $tableName = $this->getTableName();
    $query = "SELECT * from $tableName WHERE id = :id";
    return $this->queryOne($query, ["id" => $id]);
  }

  public function save(Entity $entity): string|array
  {
    $tableName = $this->getTableName();
    $props = $this->getProperties();
    $propNames = join(", ", $props);
    $propParams = array_merge(...array_map(fn($prop) => [":$prop" => $entity->{$prop}], $props));
    $propParamNames = join(", ", array_keys($propParams));
    $query = "INSERT INTO $tableName ($propNames) VALUES ($propParamNames);";
    $saved = $this->createSQL($query, $propParams);
    return $this->findById($saved);
  }

  public function update(Entity $entity): string|array
  {
    $tableName = $this->getTableName();
    $props = $this->getProperties();
    $propParams = array_merge(...array_map(fn($prop) => [":$prop" => $entity->{$prop}], $props));
    $propParamValues = "";
    foreach (array_slice($props, 1) as $prop) {
      $propParamValues .= "$prop = :{$prop},";
    }
    $propParamValues = rtrim($propParamValues, ",");

    $query = "UPDATE $tableName SET $propParamValues WHERE id = :id";
    $this->createSQL($query, $propParams);
    return $this->findById($entity->id);
  }

  public function delete(int $id): bool
  {
    $tableName = $this->getTableName();
    if (empty($this->findById($id))) {
      return false;
    }
    $query = "DELETE FROM $tableName WHERE id = :id";
    $this->executeSQL($query, ["id" => $id]);
    return true;
  }
}
?>