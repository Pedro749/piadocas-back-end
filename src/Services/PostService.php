<?php
  namespace Src\Services;
  use Src\Models\PostModel;

  class PostService 
  {

    public static function select($params) {
      $id = isset($params['idpost']) ? $params['idpost'] : null;
      $result = PostModel::select((int) $id);
      return $result;
    }
    
    public static function create($params) {
      if (!isset($params['iduser']) || 
          !isset($params['post']) 
      ) {
          return false;
      }

      $post = [
        "IdUser" => $params['iduser'], 
        "Post" => $params['post']
      ];
      $result = PostModel::create($post);
      return $result;
    }

    public static function update($params) {
      if (!isset($params['iduser']) || !isset($params['idpost']) ) {
        return false;
      }

      $updatePost = [
        "IdUser" => (int) $params['iduser'], 
        "IdPost" =>  (int) $params['idpost'],
        "Post" => isset($params['post']) ? $params['post'] : ""
      ];

      $result = PostModel::update($updatePost);
      return $result;
    }

    public static function delete($params) {
      if (
          !isset($params['iduser']) || 
          !isset($params['idpost']) ||
          !isset($params['email']) ||
          !isset($params['password']) 
      ) {
        return false;
      }
      
      $deletePost = [
        "IdUser" => (int) $params['iduser'],
        "IdPost" => (int) $params['idpost'],
        "Email" => $params['email'],
        "Password" => $params['password']
      ];
      $result = PostModel::delete($deletePost);
      return $result;
    }
    
    public static function like($params) {
      if (!isset($params['iduserlike']) || !isset($params['idpost'])) {
        return false;
      }

      $dataPost = [
        'IdUserLike' => $params['iduserlike'], 
        "IdPost" => $params['idpost']
      ];
      
      $result = PostModel::like($dataPost);
      return $result;
    }
  }
 