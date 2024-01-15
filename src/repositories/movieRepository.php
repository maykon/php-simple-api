<?php
require_once __DIR__ . "/../meta/attributes.php";
require_once __DIR__ . "/../models/movie.php";
require_once __DIR__ . "/baseRepository.php";

#[EntityName(Movie::class)]
class MovieRepository extends Repository
{
}
?>