<?php
require_once __DIR__ . "/baseController.php";
require_once __DIR__ . "/../models/movie.php";
require_once __DIR__ . "/../repositories/movieRepository.php";

class MovieController extends BaseController
{
  private MovieRepository $movieRepository;

  public function __construct()
  {
    $this->movieRepository = new MovieRepository();
    $this->resourceName = $this->movieRepository->getEntityName();
  }

  public function list()
  {
    return $this->ok($this->movieRepository->findAll());
  }

  public function create()
  {
    $input = $this->getInputs();
    $newMovie = new Movie(null, $input["name"], $input["category"]);
    $movieSaved = $this->movieRepository->save($newMovie);
    return $this->created($movieSaved);
  }

  public function update()
  {
    $input = $this->getInputs();
    if (empty($input["id"])) {
      return $this->notFound();
    }

    if (empty($this->movieRepository->findById($input["id"]))) {
      return $this->notFound();
    }

    $newMovie = new Movie($input["id"], $input["name"], $input["category"]);
    $movieSaved = $this->movieRepository->update($newMovie);
    return $this->ok($movieSaved);
  }

  public function delete()
  {
    $input = $this->getInputs();
    $id = $input["id"];

    $deleted = $this->movieRepository->delete($id);
    if (!$deleted) {
      return $this->notFound();
    }
    return $this->deleted();
  }

  public function notAllowed()
  {
    return $this->methodNotAllowed();
  }
}
?>