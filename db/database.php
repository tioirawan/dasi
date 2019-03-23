<?php

class Database
{
    private $contHost = 'localhost';
    private $contnama = 'dasi';
    private $contUsernama = 'root';
    private $contUserPassword = '';

    private $cont  = null;

    public function __construct()
    {
        if ($this->cont == null) {

            try {
                $this->cont =  new PDO(
                    "mysql:host=" . $this->contHost .
                        ";" . "dbname=" . $this->contnama,
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

    public function registerAdmin($nama, $email, $password)
    {
        try {
            $query = $this->cont->prepare(
                "INSERT INTO admin(nama, email, level, password) 
                VALUES (:nama,:email,'admin',:password)"
            );

            $enc_password = hash('sha256', $password);

            $query->bindParam("nama", $nama, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);

            $query->execute();

            return $this->cont->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    public function loginAdmin($email, $password)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT id FROM admin 
                WHERE email=:email
                AND password=:password"
            );

            $query->bindParam("email", $email, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                return $result->id;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    public function getAdminById($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT id, nama, email, level
                FROM admin WHERE id=:id"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetch($rettype);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getAllUsers()
    {
        $stmt = $this->cont->prepare("SELECT * FROM users");

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function register($nama, $email, $level, $tingkatan, $kelas, $jurusan, $nisn, $saldo, $password)
    {
        try {
            $query = $this->cont->prepare(
                "INSERT INTO users(nama, email, level, tingkatan, kelas, jurusan, nisn, saldo, password) 
                VALUES (:nama,:email,:level,:tingkatan,:kelas,:jurusan,:nisn,:saldo,:password)"
            );

            $enc_password = hash('sha256', $password);

            $query->bindParam("nama", $nama, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("level", $level, PDO::PARAM_STR);
            $query->bindParam("tingkatan", $tingkatan, PDO::PARAM_STR);
            $query->bindParam("kelas", $kelas, PDO::PARAM_STR);
            $query->bindParam("jurusan", $jurusan, PDO::PARAM_STR);
            $query->bindParam("nisn", $nisn, PDO::PARAM_STR);
            $query->bindParam("saldo", $saldo, PDO::PARAM_INT);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);

            $query->execute();

            return $this->cont->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function login($email, $password)
    {
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

            // print_r($query->fetchAll(PDO::FETCH_ASSOC));

            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                return $result->id;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function searchUser($query)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT id, nama, email, level, tingkatan, kelas, jurusan, nisn, saldo
                FROM users WHERE name LIKE '%:query%' OR email=':query' OR nisn=':query'"
            );

            $query->bindParam("query", $query, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_OBJ);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getUserById($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT id, nama, email, level, tingkatan, kelas, jurusan, nisn, saldo
                FROM users WHERE id=:id"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetch($rettype);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function createDonation($judul, $deskripsi, $target, $idposter)
    {
        try {
            $query = $this->cont->prepare(
                "INSERT INTO donasi(judul, deskripsi, posted_by, target_donasi) 
                VALUES (:judul,:deskripsi,:idposter,:tgt)"
            );

            $query->bindParam("judul", $judul, PDO::PARAM_STR);
            $query->bindParam("deskripsi", $deskripsi, PDO::PARAM_STR);
            $query->bindParam("tgt", $target, PDO::PARAM_INT);
            $query->bindParam("idposter", $idposter, PDO::PARAM_STR);            

            $query->execute();

            return $this->cont->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getAllDonations($rettype) {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM donasi"
            );

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetchAll($rettype);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function disconnect()
    {
        $this->cont = null;
    }
}
