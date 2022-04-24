<?php
  namespace App\Services;
  use App\Models\User;

  class UserService {

    private static function separateroutes( $params) {
      $endPoints = explode('/', $params);
      echo "<pre>"; var_dump($endPoints);
    }

    public static function routes(array $params) {
      if (!isset($params['url'])) return false;


      UserService::separateroutes($params['url']); 
    }
  }

  User::select();