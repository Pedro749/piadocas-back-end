<?php
  namespace App\Controllers;
  use App\Services\PostService;

  class PostController {

    private static function separateRoutes( $params) {
      $endPoints = explode('/', $params['url']);

      if ($endPoints[0] !== "api") return false;
      if ($endPoints[1] !== "post") return false;
      if (!isset($endPoints[2])) return false;

      switch ($endPoints[2]) {
        case 'select':
          return PostService::select($params);
          break;
        case 'create':
          return PostService::create($params);
          break;
        case 'update':
            return PostService::update($params);
            break;
          case 'delete':
            return PostService::delete( $params);
            break;
          case 'like':
            return PostService::like($params);;
            break;
        default:
          return false;
          break;
      }

    }

    public static function routes(array $params) {
      if (!isset($params['url'])) return false;

      return PostController::separateRoutes($params); 
    }
  }
 