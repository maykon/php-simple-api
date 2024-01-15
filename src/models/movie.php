<?php
require_once __DIR__ . "/../meta/attributes.php";
require_once __DIR__ . "/entity.php";

#[TableName("movies")]
class Movie extends Entity
{
  public function __construct(public ?int $id = null, public ?string $name = null, public ?string $category = null)
  {
    parent::__construct($id);
  }
}
?>