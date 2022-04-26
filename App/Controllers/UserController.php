<?php
  namespace App\Controllers;
  use App\Services\UserService;

  class UserController {

    private static function separateRoutes( $params) {
      $endPoints = explode('/', $params['url']);

      if ($endPoints[0] !== "api") return false;
      if ($endPoints[1] !== "user") return false;
      if (!isset($endPoints[2])) return false;

      switch ($endPoints[2]) {
        case 'select':
          return UserService::select($params);
          break;
        case 'create':
          return UserService::create($params);
          break;
        case 'update':
            return UserService::update($params);
            break;
          case 'delete':
            return UserService::delete( $params);
            break;
          case 'login':
            return UserService::login($params);;
            break;
        default:
          return false;
          break;
      }

    }

    public static function routes(array $params) {
      if (!isset($params['url'])) return false;

      return UserController::separateRoutes($params); 
    }
  }
 