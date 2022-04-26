<?php
  header('Content-Type: application/json');
  use Src\Controllers\UserController;
  use Src\Controllers\PostController;
  require_once '../vendor/autoload.php';
  
  $result = false;
  if (!isset($_REQUEST['url'])) return false;
  $endPoints = explode('/', $_REQUEST['url']);
  
  switch($endPoints[1]) {
    case 'user':
      $result = UserController::routes($_REQUEST);
      break;
    case 'post':
      $result = PostController::routes($_REQUEST);
      break;
  }

  if ($result === false) {
    echo json_encode(["status" => 'erro', "data" => $result]); 
  } else {
    echo json_encode(["status" => 'sucesso', "data" => $result]);
  }