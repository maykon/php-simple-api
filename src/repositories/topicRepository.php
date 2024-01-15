<?php
require_once __DIR__ . "/../meta/attributes.php";
require_once __DIR__ . "/../models/topic.php";
require_once __DIR__ . "/baseRepository.php";

#[EntityName(Topic::class)]
class TopicRepository extends Repository
{
}
?>