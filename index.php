<?php
  use App\Models\User;
  use App\Services\UserService;
  require_once './vendor/autoload.php';
  echo "INDEX!";

echo "<pre>"; var_dump($_REQUEST); die;

UserService::routes($_REQUEST);