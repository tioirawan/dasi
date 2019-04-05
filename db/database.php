<?php

require __DIR__ . "/../process/utils.php";

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

    public function getSchoolData($id, $rettype) {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM schools WHERE id=:id"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetch($rettype);
            }
        }catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function registerAdmin($nama, $email, $password, $id_sekolah)
    {
        try {
            $query = $this->cont->prepare(
                "INSERT INTO admin(nama, email, level, password, id_sekolah) 
                VALUES (:nama,:email,'admin',:password,:idsekolah)"
            );

            $enc_password = hash('sha256', $password);

            $query->bindParam("nama", $nama, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);
            $query->bindParam("idsekolah", $id_sekolah, PDO::PARAM_INT);

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

    public function validateAdminPassword($id, $password)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT id FROM admin 
                WHERE id=:id
                AND password=:password"
            );

            $enc_password = hash('sha256', $password);

            $query->bindParam("id", $id, PDO::PARAM_STR);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return true;
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
                "SELECT id, nama, email, level, id_sekolah
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

    public function getAllUsers($idsekolah)
    {
        try {
            $stmt = $this->cont->prepare(
                "SELECT id, nama, kelamin, email, level, tingkatan, kelas, jurusan, nisn, saldo 
                FROM users WHERE id_sekolah=:idsekolah ORDER BY id ASC");

            $stmt->bindParam("idsekolah", $idsekolah, PDO::PARAM_INT);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function register($nama, $id_sekolah, $kelamin, $email, $tingkatan, $kelas, $jurusan, $nisn, $saldo)
    {
        try {
            $query = $this->cont->prepare(
                "INSERT INTO users(nama, id_sekolah, kelamin, email, level, tingkatan, kelas, jurusan, nisn, saldo, password) 
                VALUES (:nama,:idsekolah,:kelamin,:email,'siswa',:tingkatan,:kelas,:jurusan,:nisn,:saldo,:password)"
            );

            $password = generateRandom();


            $enc_password = hash('sha256', $password);

            echo $password . "<br>";
            echo $enc_password . "<br>";

            $query->bindParam("nama", $nama, PDO::PARAM_STR);
            $query->bindParam("idsekolah", $id_sekolah, PDO::PARAM_INT);
            $query->bindParam("kelamin", $kelamin, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("tingkatan", $tingkatan, PDO::PARAM_STR);
            $query->bindParam("kelas", $kelas, PDO::PARAM_STR);
            $query->bindParam("jurusan", $jurusan, PDO::PARAM_STR);
            $query->bindParam("nisn", $nisn, PDO::PARAM_STR);
            $query->bindParam("saldo", $saldo, PDO::PARAM_INT);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);

            $query->execute();

            return array($this->cont->lastInsertId(), $password);
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

            $enc_password = hash('sha256', $password);

            $query->bindParam("email", $email, PDO::PARAM_STR);
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

    public function validatePassword($id, $password)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT id FROM users 
                WHERE id=:id
                AND password=:password"
            );

            $enc_password = hash('sha256', $password);

            $query->bindParam("id", $id, PDO::PARAM_STR);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return true;
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
                "SELECT id, nama, email, kelamin, level, tingkatan, kelas, jurusan, nisn, saldo, id_sekolah
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

    public function getUserByNISN($nisn, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT id, nama, email, kelamin, level, tingkatan, kelas, jurusan, nisn, saldo, id_sekolah
                FROM users WHERE nisn=:nisn"
            );

            $query->bindParam("nisn", $nisn, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetch($rettype);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function userDeposit($userid, $amount) {
        try {
            $query = $this->cont->prepare(
                "UPDATE users
                SET saldo = saldo + :amount
                WHERE id=:userid"
            );

            $query->bindParam("userid", $userid, PDO::PARAM_STR);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);

            $query->execute();

            if ($query->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function userWithdrawal($userid, $amount) {
        try {
            $query = $this->cont->prepare(
                "UPDATE users
                SET saldo = saldo - :amount
                WHERE id=:userid"
            );

            $query->bindParam("userid", $userid, PDO::PARAM_STR);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);

            $query->execute();

            if ($query->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function transferByNISN($userid, $nisn, $amount) {
        try {
            $query = $this->cont->prepare(
                "UPDATE users
                SET saldo = saldo - :amount
                WHERE id=:userid"
            );

            $query->bindParam("userid", $userid, PDO::PARAM_STR);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);

            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $query = $this->cont->prepare(
                "UPDATE users
                SET saldo = saldo + :amount
                WHERE nisn=:nisn"
            );

            $query->bindParam("nisn", $nisn, PDO::PARAM_STR);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);


            $query->execute();

            if ($query->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getUserTransactionHistory($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT *
                 FROM users_transaction
                 WHERE user_id=:id
                 ORDER BY tanggal DESC"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetchAll($rettype);
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function createDonation($judul, $deskripsi, $target, $idposter)
    {
        try {
            $query = $this->cont->prepare(
                "INSERT INTO donation(judul, deskripsi, posted_by, target_donasi, id_sekolah) 
                VALUES (:judul,:deskripsi,:idposter,:tgt,:idsekolah)"
            );

            $query->bindParam("judul", $judul, PDO::PARAM_STR);
            $query->bindParam("deskripsi", $deskripsi, PDO::PARAM_STR);
            $query->bindParam("tgt", $target, PDO::PARAM_INT);
            $query->bindParam("idposter", $idposter, PDO::PARAM_STR);
            $query->bindParam("idsekolah", 
                $this->getAdminById($idposter, PDO::FETCH_OBJ)->id_sekolah, 
                PDO::PARAM_INT
            );

            $query->execute();

            return $this->cont->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getDonation($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM donation WHERE id=:id"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetch($rettype);
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getDonatur($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT users.nama, users.tingkatan, users.kelas,
                 users.jurusan, users_donation.jumlah, users_donation.private
                 FROM users_donation INNER JOIN users
                 ON users_donation.user_id = users.id
                 WHERE users_donation.donation_id=:id
                 ORDER BY tanggal DESC"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetchAll($rettype);
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getAllDonations($id_sekolah, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM donation WHERE id_sekolah=:idsekolah"
            );

            $query->bindParam("idsekolah", $id_sekolah, PDO::PARAM_INT);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetchAll($rettype);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function fundDonation($donation_id, $user_id, $amount, $isprivate)
    {
        try {
            $query = $this->cont->prepare(
                "UPDATE donation
                SET terkumpul = terkumpul + :amount
                WHERE id=:donationid"
            );

            $query->bindParam("donationid", $donation_id, PDO::PARAM_STR);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);

            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $query = $this->cont->prepare(
                "UPDATE users
                SET saldo = saldo - :amount
                WHERE id=:userid"
            );

            $query->bindParam("userid", $user_id, PDO::PARAM_STR);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);


            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $query = $this->cont->prepare(
                "INSERT INTO users_donation(donation_id, user_id, jumlah, private, id_sekolah) 
                VALUES (:donationid,:userid,:amount,:isprivate,:idsekolah)"
            );

            $query->bindParam("donationid", $donation_id, PDO::PARAM_INT);
            $query->bindParam("userid", $user_id, PDO::PARAM_INT);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);
            $query->bindParam("isprivate", $isprivate, PDO::PARAM_BOOL);
            $query->bindParam("idsekolah", $this->getUserById($user_id, PDO::FETCH_OBJ)->id_sekolah, PDO::PARAM_INT);

            $query->execute();

            return $this->cont->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function addTransaction($kredit, $type, $jenis, $userid, $method, $description)
    {
        try {
            $query = $this->cont->prepare(
                "INSERT INTO users_transaction(kredit, debit, tipe, jenis, user_id, metode, deskripsi, id_sekolah)
                VALUES (:kredit,:debit,:tipe,:jenis,:userid,:metode,:deskripsi,:idsekolah)"
            );

            $debit = $this->getUserById($userid, PDO::FETCH_OBJ)->saldo;

            $query->bindParam("kredit", $kredit, PDO::PARAM_INT);
            $query->bindParam("debit", $debit, PDO::PARAM_INT);
            $query->bindParam("tipe", $type, PDO::PARAM_STR);
            $query->bindParam("jenis", $jenis, PDO::PARAM_STR);
            $query->bindParam("userid", $userid, PDO::PARAM_STR);
            $query->bindParam("metode", $method, PDO::PARAM_STR);
            $query->bindParam("deskripsi", $description, PDO::PARAM_STR);
            $query->bindParam("idsekolah", $this->getUserById($userid, PDO::FETCH_OBJ)->id_sekolah, PDO::PARAM_INT);

            $query->execute();

            return $this->cont->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getTransaction($id, $rettype) {
        try {
            try {
                $query = $this->cont->prepare(
                    "SELECT * FROM users_transaction WHERE id=:id"
                );
    
                $query->bindParam("id", $id, PDO::PARAM_STR);
    
                $query->execute();
    
                if ($query->rowCount() > 0) {
                    return $query->fetch($rettype);
                }
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        }catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function registerToko($nama, $deskripsi, $id_sekolah)
    {
        try {
            $query = $this->cont->prepare(
                "INSERT INTO toko(nama, deskripsi, id_sekolah)
                VALUES (:nama,:deskripsi,:idsekolah)"
            );

            $query->bindParam("nama", $nama, PDO::PARAM_STR);
            $query->bindParam("deskripsi", $deskripsi, PDO::PARAM_STR);
            $query->bindParam("idsekolah", $id_sekolah, PDO::PARAM_INT);

            $query->execute();

            return $this->cont->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getToko($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM toko WHERE id=:id"
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

    public function getTokoList($id_sekolah, $rettype)
    {
        $stmt = $this->cont->prepare("SELECT * FROM toko WHERE id_sekolah=:idsekolah");

        $stmt->bindParam("idsekolah", $id_sekolah, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll($rettype);
    }

    public function getTransaksiToko($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM toko_transaction WHERE toko_id=:id ORDER BY id DESC"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetchAll($rettype);
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function payToko($userid, $uniqueid, $amount) {
        try {
            $QR = $this->getQR($uniqueid, PDO::FETCH_OBJ);

            $query = $this->cont->prepare(
                "UPDATE toko
                SET saldo = saldo + :amount
                WHERE id=:idtoko"
            );

            $query->bindParam("idtoko", $QR->id_toko, PDO::PARAM_STR);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);

            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $query = $this->cont->prepare(
                "UPDATE users
                SET saldo = saldo - :amount
                WHERE id=:userid"
            );

            $query->bindParam("userid", $userid, PDO::PARAM_STR);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);


            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $query = $this->cont->prepare(
                "INSERT INTO toko_transaction(toko_id, user_id, qr_id, jumlah, id_sekolah)
                VALUES (:tokoid,:userid,:qrid,:jumlah,:idsekolah)"
            );

            $query->bindParam("tokoid", $QR->id_toko, PDO::PARAM_INT);
            $query->bindParam("userid", $userid, PDO::PARAM_INT);
            $query->bindParam("qrid", $QR->id, PDO::PARAM_STR);
            $query->bindParam("jumlah", $amount, PDO::PARAM_INT);
            $query->bindParam("idsekolah", $this->getUserById($userid, PDO::FETCH_OBJ)->id_sekolah, PDO::PARAM_INT);

            $query->execute();

            return $this->cont->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function newQr($judul, $nilai, $tetap, $id_admin, $id_toko)
    {
        try {
            $uniid = "";

            do {
                $uniid = generateRandom();

                $chk = $this->cont->prepare("SELECT * FROM qrcode WHERE unique_id=:uniid"); 
                $chk->bindParam("uniid", $uniid);
                $chk->execute(); 
            } while ($chk->rowCount() > 0);


            $query = $this->cont->prepare(
                "INSERT INTO qrcode(judul, nilai, tetap, generated_by, id_toko, unique_id, id_sekolah)
                VALUES (:judul,:nilai,:tetap,:id_admin,:id_toko,:id_unik,:idsekolah)"
            );

            $query->bindParam("judul", $judul, PDO::PARAM_STR);
            $query->bindParam("nilai", $nilai, PDO::PARAM_INT);
            $query->bindParam("tetap", $tetap, PDO::PARAM_BOOL);
            $query->bindParam("id_admin", $id_admin, PDO::PARAM_STR);
            $query->bindParam("id_toko", $id_toko, PDO::PARAM_STR);
            $query->bindParam("id_unik", $uniid, PDO::PARAM_STR);
            $query->bindParam("idsekolah", $this->getAdminById($id_admin, PDO::FETCH_OBJ)->id_sekolah, PDO::PARAM_INT);

            $query->execute();

            return $uniid;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getQR($uniqueid, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM qrcode WHERE unique_id=:unid"
            );

            $query->bindParam("unid", $uniqueid, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetch($rettype);
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getQRCodeToko($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM qrcode WHERE id_toko=:id ORDER BY id DESC"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetchAll($rettype);
            }
        } catch (PDOException $e) {
            return false;
        }
    }

    public function disconnect()
    {
        $this->cont = null;
    }
}
