<?php
abstract class BaseController
{
  public $resourceName = null;

  protected function getInputs()
  {
    return json_decode(file_get_contents("php://input"), true);
  }

  private function apiResponse($data, $status = 200)
  {
    http_response_code($status);
    echo json_encode($data);
  }

  public function ok($data)
  {
    return $this->apiResponse($data);
  }

  public function created($data)
  {
    return $this->apiResponse($data, 201);
  }

  public function deleted($message = null)
  {
    return $this->apiResponse(["message" => empty($message) ? "$this->resourceName Deleted" : $message]);
  }

  public function notFound($message = null)
  {
    return $this->apiResponse(["message" => empty($message) ? "$this->resourceName Not Found" : $message], 404);
  }

  public function methodNotAllowed($message = null)
  {
    return $this->apiResponse(["message" => empty($message) ? "Method Not Allowed" : $message], 405);
  }

  abstract function list();
  abstract function create();
  abstract function update();
  abstract function delete();
  abstract function notAllowed();
}
?>