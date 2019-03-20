<?php

class Database {
    private $contHost = 'localhost';
    private $contnama = 'dasi';
    private $contUsernama = 'root';
    private $contUserPassword = '';

    private $cont  = null;

    public function __construct()
    {
         // One connection through whole application
         if ($this->cont == null) {
            try {
                $this->cont =  new PDO(
                    "mysql:host=" . $this->contHost . 
                    ";" . "dbnama=" . $this->contnama, 
                    $this->contUsernama,  
                    $this->contUserPassword
                );
                $this->cont->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        
        return $this->cont;
    }

    public function getAllUsers()
    {
        $stmt = $this->cont->prepare("SELECT * FROM users"); 

        $stmt->execute();
   
        return $stmt->fetchAll(PDO::FETCH_ASSOC);     
    }

    public function register($nama, $email, $level, $nisn, $saldo, $password) {
        try {
            $query = $this->cont->prepare(
                "INSERT INTO users(nama, email, level, nisn, saldo, password) 
                VALUES (:nama,:email,:level,:nisn,:saldo,:password)"
            );

            $enc_password = hash('sha256', $password);
            
            $query->bindParam("nama", $nama, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("level", $level, PDO::PARAM_STR);
            $query->bindParam("nisn", $level, PDO::PARAM_STR);
            $query->bindParam("saldo", $level, PDO::PARAM_INT);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);

            $query->execute();

            return $this->cont->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function login($email, $password) {
        try {
            $query = $this->cont->prepare(
                "SELECT id FROM users 
                WHERE email=:email
                AND password=:password"
            );

            $query->bindParam("email", $email, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                return $result->user_id;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function userDetails($user_id)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT user_id, name, username, email 
                FROM users WHERE user_id=:user_id"
            );
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public static function disconnect()
    {
        $this->cont = null;
    }
}
 
