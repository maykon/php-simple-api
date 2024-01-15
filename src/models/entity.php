<?php
require_once __DIR__ . "/../meta/attributes.php";

abstract class Entity
{
  public function __construct(public ?int $id = null)
  {
  }

  public static function tableName(): string
  {
    try {
      $entityClass = new ReflectionClass(static::class);
      [$tableName] = $entityClass->getAttributes(TableName::class);
      $instance = $tableName->newInstance();
      return $instance->tableName;
    } catch (ReflectionException $e) {
      return static::class;
    }
  }
}
?>