<?php
#[Attribute(Attribute::TARGET_CLASS)]
class TableName
{
  public function __construct(public string $tableName = '')
  {
  }
}

#[Attribute(Attribute::TARGET_CLASS)]
class EntityName
{
  public function __construct(public string $entityName = '')
  {
  }
}
?>