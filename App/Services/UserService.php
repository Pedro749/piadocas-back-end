<?php
  namespace App\Services;
  use App\Models\User;

  class UserService {

    private static function separateRoutes( $params) {
      $endPoints = explode('/', $params['url']);

      if ($endPoints[0] !== "api") return false;
      if ($endPoints[1] !== "user") return false;
      if (!isset($endPoints[2])) return false;

      switch ($endPoints[2]) {
        case 'select':
          $id = isset($params['id']) ? $params['id'] : null;
          $result = User::select((int) $id);
          return $result;
          break;
        case 'create':
          if (!isset($params['nome']) || 
              !isset($params['email']) || 
              !isset($params['password'])
          ) {
            return false;
          }

          $user = [
            "Nome" => $params['nome'], 
            "Email" => $params['email'], 
            "Password" => $params['password']
          ];
          $result = User::create($user);
          return $result;
          break;
          case 'update':
            if (!isset($params['iduser'])) return false;
            
            $updateUser = [
              "IdUser" => (int) $params['iduser'], 
              "Nome" => isset($params['nome']) ? $params['nome'] : null,
              "Email" => isset($params['email']) ? $params['email'] : null, 
              "Password" => isset($params['password']) ? $params['password'] : null
            ];
            $result = User::update($updateUser);
            return $result;
            break;
          case 'delete':
            if (!isset($params['id']) || empty($params['id'])) return false;
            
            $result = User::delete((int) $params['id']);
            return $result;
            break;
          case 'login':
            if (!isset($params['email']) || !isset($params['password'])) {
              return false;
            }

            $dataUser = ['Email' => $params['email'], "Password" => $params['password']];
        
            $result = User::login($dataUser);
            return $result;
            break;
        default:
          # code...
          break;
      }

    }

    public static function routes(array $params) {
      if (!isset($params['url'])) return false;

      return UserService::separateRoutes($params); 
    }
  }
 