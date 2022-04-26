<?php
  namespace App\Models;
  use Src\Database\Connection\Connection;

  class UserModel
  {
    private static $table = 'users';

    public static function select(int $id = 0) 
    {
      $con = Connection::getInstance();
      $sql = "SELECT * FROM ". self::$table;
      if ($id !== 0) $sql = $sql." WHERE IdUser = :id";
      $stmt = $con->prepare($sql);
      if ($id !== 0) $stmt->bindValue( ':id', $id, \PDO::PARAM_INT);
      
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
      } else {
        return "Nenhum registro encontrado!";
      }
    }

    public static function create(array $user = []) 
    {
      $con = Connection::getInstance();
      if (!isset($user['Nome']) || !isset($user['Email']) || !isset($user['Password'])) return false;

      $sql = "SELECT * FROM ".self::$table." WHERE Email = :email ";
      $stmt = $con->prepare($sql);
      $stmt->bindValue( ':email', $user['Email'], \PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() > 0) return "Email já utilizado!";

      $sql = "INSERT INTO ".self::$table." 
                (Nome,  Email, Password, DataCriacao)
              VALUES 
                (:nome, :email, :password, NOW())";
      $user['Password'] = password_hash($user['Password'], PASSWORD_DEFAULT);
      $stmt = $con->prepare($sql);
      $stmt->bindValue( ':nome', $user['Nome'], \PDO::PARAM_STR);
      $stmt->bindValue( ':email', $user['Email'], \PDO::PARAM_STR);
      $stmt->bindValue( ':password', $user['Password'], \PDO::PARAM_STR);

      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return "Sucesso ao cadastrar usuário!";
      } else {
        return "Usuário não cadastrado!";
      }
      
    }

    public static function update(array $user) 
    {
      if (!isset($user['IdUser']) || empty($user['IdUser'])) return false;
      $con = Connection::getInstance();

      $sql = "SELECT * FROM ".self::$table." WHERE Email = :email ";
      $stmt = $con->prepare($sql);
      $stmt->bindValue( ':email', $user['Email'], \PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() > 0) return "Email já utilizado!";

      $sql = 'UPDATE '.self::$table.' SET';

      if (isset($user['Nome'])) $sql = $sql.' Nome = :nome ,';
      if (isset($user['Email'])) $sql = $sql.' Email = :email ,';
      if (isset($user['Password'])) {
        $sql = $sql.' Password = :password';
        $user['Password'] = password_hash($user['Password'], PASSWORD_DEFAULT);
      }

      $sql = $sql .' WHERE IdUser = :idUser;';
      $sql = str_replace( ', W', 'W', $sql);

      $stmt = $con->prepare($sql);

      if (isset($user['Nome'])) {
        $stmt->bindValue( ':nome', $user['Nome'], \PDO::PARAM_STR);
      }
      if (isset($user['Email'])) { 
        $stmt->bindValue( ':email', $user['Email'], \PDO::PARAM_STR);
      }
      if (isset($user['Password'])) { 
        $stmt->bindValue( ':password', $user['Password'], \PDO::PARAM_STR);
      }

      $stmt->bindValue( ':idUser', $user['IdUser'], \PDO::PARAM_INT);

      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return [true, "Registro Atualizado!"];
      } else {
        return [false, "Registro não atualizado!"];
      }

    }

    public static function delete(int $id = 0) 
    {
      if ($id === 0) return false;

      $con = Connection::getInstance();
      $sql = " CALL deleteUser(:id);";

      $stmt = $con->prepare($sql);
      $stmt->bindValue( ':id', $id, \PDO::PARAM_INT);
      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        return "Usuario deletado!";
      } else {
        return false;
      }
    }

    public static function login(array $user = []) 
    {
      if (empty($user)) return false;

      $con = Connection::getInstance();
      $sql = 'SELECT * FROM users WHERE Email = :email';
      $stmt = $con->prepare($sql);
      $stmt->bindValue( ':email', $user['Email'], \PDO::PARAM_STR);
      $stmt->execute();

      if ($stmt->rowCount() === 0) return false;

      $dataUser = $stmt->fetch(\PDO::FETCH_ASSOC);

      if (!isset($user['Password']) || !isset($dataUser['Password'])) return false;
      if (password_verify($user['Password'] , $dataUser['Password'])) {
       return true;
      } else {
        return false;
      }
    }
  }
