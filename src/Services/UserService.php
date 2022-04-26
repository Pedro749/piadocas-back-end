<?php
  namespace Src\Services;
  use Src\Models\UserModel;

  class UserService {

    public static function select($params) 
    {
      $id = isset($params['id']) ? $params['id'] : null;
      $result = UserModel::select((int) $id);
      return $result;
    }
    
    public static function create($params)
    {
      if (!isset($params['name']) || 
          !isset($params['email']) || 
          !isset($params['password'])
      ) {
          return false;
      }

      $user = [
        "Nome" => $params['name'], 
        "Email" => $params['email'], 
        "Password" => $params['password']
      ];
      $result = UserModel::create($user);
      return $result;
    }

    public static function update($params)
    {
      if (!isset($params['iduser'])) return false;

      $updateUser = [
        "IdUser" => (int) $params['iduser'], 
        "Nome" => isset($params['name']) ? $params['name'] : null,
        "Email" => isset($params['email']) ? $params['email'] : null, 
        "Password" => isset($params['password']) ? $params['password'] : null
      ];
      $result = UserModel::update($updateUser);
      return $result;
    }

    public static function delete($params)
    {
      if (
        !isset($params['iduser']) || 
        !isset($params['password']) || 
        !isset($params['email']) 
      ) {
        return false;
      }

      $userDelete = [
        "Email" => $params['email'],
        "Password" => $params['password'],
        "IdUser" => (int) $params['iduser']
      ];
      
      $result = UserModel::delete($userDelete);
      return $result;
    }
    
    public static function login($params)
    {
      if (!isset($params['email']) || !isset($params['password'])) {
        return false;
      }
      $dataUser = ['Email' => $params['email'], "Password" => $params['password']];
      $result = UserModel::login($dataUser);
      return $result;
    }
  }
 