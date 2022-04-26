<?php
  namespace App\Models;
  use Src\Database\Connection\Connection;

  class PostModel
  {
    private static $table = 'posts';

    public static function select(int $id = 0) 
    {
      $con = Connection::getInstance();
      $sql = "SELECT * FROM ". self::$table;
      if ($id !== 0) $sql = $sql." WHERE IdPost = :id";
      $stmt = $con->prepare($sql);
      if ($id !== 0) $stmt->bindValue( ':id', $id, \PDO::PARAM_INT);
      
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
      } else {
        return "Nenhum registro encontrado!";
      }
    }

    public static function create(array $post = []) 
    {
      $con = Connection::getInstance();
      if (!isset($post['IdUser']) || !isset($post['Post'])) return false;
      $sql = "INSERT INTO ".self::$table." 
                (IdUser,  Post, Likes, DataCriacao)
              VALUES 
                (:iduser, :post, 0, NOW())";
      $stmt = $con->prepare($sql);

      $stmt->bindValue( ':iduser', $post['IdUser'], \PDO::PARAM_STR);
      $stmt->bindValue( ':post', $post['Post'], \PDO::PARAM_STR);

      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return "Sucesso ao cadastrar post!";
      } else {
        return "Post não cadastrado!";
      }
      
    }

    public static function update(array $post) 
    {
      if (!isset($post['IdPost']) || empty($post['IdPost']) || 
        !isset($post['IdUser']) || empty($post['IdUser']) ||
        !isset($post['Post'])
      ) {
        return false;
      }
      $con = Connection::getInstance();

      $sql = 'UPDATE '.self::$table.' 
                SET Post = :post  
              WHERE 
                IdUser = :idUser AND
                IdPost = :idPost ;';
      $stmt = $con->prepare($sql);

      $stmt->bindValue( ':post', $post['Post'], \PDO::PARAM_STR);
      $stmt->bindValue( ':idUser', $post['IdUser'], \PDO::PARAM_STR);
      $stmt->bindValue( ':idPost', $post['IdPost'], \PDO::PARAM_STR);

      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return [true, "Registro Atualizado!"];
      } else {
        return [false, "Registro não atualizado!"];
      }

    }

    public static function delete(array  $post = []) 
    {
      if ($post === []) return false;
      if (!isset($post['IdUser']) || !isset($post['IdPost'])) {
        return false;
      }
      
      $con = Connection::getInstance();
      $sql = "DELETE FROM likes WHERE IdPost = :idPost;";
      $stmt = $con->prepare($sql);
      $stmt->bindValue( ':idPost', $post['IdPost'], \PDO::PARAM_INT);
      $stmt->execute();
      $sql = "DELETE FROM posts WHERE IdPost = :idPost AND IdUser = :idUser;";
      $stmt = $con->prepare($sql);
      
      $stmt->bindValue( ':idUser', $post['IdUser'], \PDO::PARAM_INT);
      $stmt->bindValue( ':idPost', $post['IdPost'], \PDO::PARAM_INT);
      $stmt->execute();
      
      if ($stmt->rowCount() > 0) {
        return "Post deletado!";
      } else {
        return false;
      }
    }

    public static function like(array $post = []) 
    {
      if (!isset($post['IdPost']) || !isset($post['IdUserLike']) ) return false;

      $con = Connection::getInstance();
      $sql = 'CALL likeUpdate(:idUserLike, :idPost)';
      $stmt = $con->prepare($sql);
      $stmt->bindValue( ':idUserLike', $post['IdUserLike'], \PDO::PARAM_INT);
      $stmt->bindValue( ':idPost', $post['IdPost'], \PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }
  }
