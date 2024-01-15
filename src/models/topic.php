<?php
require_once __DIR__ . "/../meta/attributes.php";
require_once __DIR__ . "/entity.php";

#[TableName("topics")]
class Topic extends Entity
{
  public function __construct(public ?int $id = null, public ?string $name = null)
  {
    parent::__construct($id);
  }
}
?>