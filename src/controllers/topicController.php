<?php
require_once __DIR__ . "/baseController.php";
require_once __DIR__ . "/../models/topic.php";
require_once __DIR__ . "/../repositories/topicRepository.php";

class TopicController extends BaseController
{
  private TopicRepository $topicRepository;

  public function __construct()
  {
    $this->topicRepository = new TopicRepository();
    $this->resourceName = $this->topicRepository->getEntityName();
  }

  public function list()
  {
    return $this->ok($this->topicRepository->findAll());
  }

  public function create()
  {
    $input = $this->getInputs();
    $newTopic = new Topic(null, $input["name"]);
    $topicSaved = $this->topicRepository->save($newTopic);
    return $this->created($topicSaved);
  }

  public function update()
  {
    $input = $this->getInputs();
    if (empty($input["id"])) {
      return $this->notFound();
    }

    if (empty($this->topicRepository->findById($input["id"]))) {
      return $this->notFound();
    }

    $newTopic = new Topic($input["id"], $input["name"]);
    $topicSaved = $this->topicRepository->update($newTopic);
    return $this->ok($topicSaved);
  }

  public function delete()
  {
    $input = $this->getInputs();
    $id = $input["id"];

    $deleted = $this->topicRepository->delete($id);
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