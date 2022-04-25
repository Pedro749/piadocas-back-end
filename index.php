<?php
  header('Content-Type: application/json');
  use App\Models\User;
  use App\Services\UserService;
  require_once './vendor/autoload.php';
  
  $result = UserService::routes($_REQUEST);

  if ($result === false) {
    echo json_encode(["status" => 'erro', "data" => $result]); 
  } else {
    echo json_encode(["status" => 'sucesso', "data" => $result]);
  }