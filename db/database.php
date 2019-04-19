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

    public function query($query)
    {
        try {
            $query = $this->cont->prepare($query);

            $query->execute();

            return $query;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function registerSchool($nama, $npsn, $status, $bentuk, $alamat, $email, $dengan_kode = false)
    {
        try {
            $kode = "";

            if ($dengan_kode) {
                do {
                    $kode = generateRandom();

                    $chk = $this->cont->prepare("SELECT * FROM schools WHERE kode=:kode");
                    $chk->bindParam("kode", $kode);
                    $chk->execute();
                } while ($chk->rowCount() > 0);
            }

            $query = $this->cont->prepare(
                "INSERT INTO schools(npsn, status, bentuk_pendidikan, nama_sekolah, email, alamat, kode, saldo)
                VALUES (:npsn,:status,:bentuk_pendidikan,:nama_sekolah,:email,:alamat,:kode,0)"
            );

            $query->bindParam("npsn", $npsn, PDO::PARAM_INT);
            $query->bindParam("status", $status, PDO::PARAM_STR);
            $query->bindParam("bentuk_pendidikan", $bentuk, PDO::PARAM_STR);
            $query->bindParam("nama_sekolah", $nama, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("alamat", $alamat, PDO::PARAM_STR);
            $query->bindParam("kode", $kode, PDO::PARAM_STR);

            $query->execute();

            return $this->cont->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getSchoolByCode($code, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM schools WHERE kode=:code"
            );

            $query->bindParam("code", $code, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetch($rettype);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getSchoolData($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM schools WHERE id=:id"
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

    public function getSchoolTotalBalance($id)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT saldo FROM schools WHERE id=:id"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $schoolBalance = $query->fetch(PDO::FETCH_OBJ)->saldo;

            $query = $this->cont->prepare(
                "SELECT SUM(saldo) AS total FROM users WHERE id_sekolah=:id"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $usersBalance = $query->fetch(PDO::FETCH_OBJ)->total;

            $query = $this->cont->prepare(
                "SELECT SUM(saldo) AS total FROM kantin WHERE id_sekolah=:id"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $kantinBalance = $query->fetch(PDO::FETCH_OBJ)->total;

            $query = $this->cont->prepare(
                "SELECT SUM(terkumpul) AS total FROM donation WHERE id_sekolah=:id"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $donation = $query->fetch(PDO::FETCH_OBJ)->total;

            return (object)[
                "sekolah" => $schoolBalance,
                "siswa" => $usersBalance,
                "kantin" => $kantinBalance,
                "donasi" => $donation,
                "total" => $usersBalance + $kantinBalance + $donation + $schoolBalance
            ];
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getSchoolUsersStats($id)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT COUNT(id) AS jumlah FROM users WHERE kelamin='laki-laki' AND id_sekolah=:id"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $jumlah_laki = $query->fetch(PDO::FETCH_OBJ)->jumlah;

            $query = $this->cont->prepare(
                "SELECT COUNT(id) AS jumlah FROM users WHERE kelamin='perempuan' AND id_sekolah=:id"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $jumlah_perempuan = $query->fetch(PDO::FETCH_OBJ)->jumlah;

            return (object)["laki" => $jumlah_laki, "perempuan" => $jumlah_perempuan, "total" => $jumlah_laki + $jumlah_perempuan];
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getSchoolTransactions($id)
    {
        try {
            try {
                $query = $this->cont->prepare(
                    "SELECT * FROM users_transaction WHERE id_sekolah=:id"
                );

                $query->bindParam("id", $id, PDO::PARAM_STR);

                $query->execute();

                if ($query->rowCount() > 0) {
                    return $query->fetchAll(PDO::FETCH_OBJ);
                }
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getSchoolSPPTransactions($id)
    {
        try {
            try {
                $query = $this->cont->prepare(
                    "SELECT * FROM users_transaction WHERE id_sekolah=:id AND tipe='spp'"
                );

                $query->bindParam("id", $id, PDO::PARAM_STR);

                $query->execute();

                if ($query->rowCount() > 0) {
                    return $query->fetchAll(PDO::FETCH_OBJ);
                }
            } catch (PDOException $e) {
                exit($e->getMessage());
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function sppWithdrawal($id_sekolah, $amount)
    {
        try {
            $query = $this->cont->prepare(
                "UPDATE schools
                SET saldo = IF(:amount <= saldo, saldo - :amount, saldo)
                WHERE id=:id"
            );

            $query->bindParam("id", $id_sekolah, PDO::PARAM_STR);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);

            $query->execute();

            if ($query->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function changeSchoolBiayaSPP($id_sekolah, $biaya)
    {
        try {
            $query = $this->cont->prepare(
                "UPDATE schools
                SET biaya_spp=:biaya
                WHERE id=:id"
            );

            $query->bindParam("id", $id_sekolah, PDO::PARAM_STR);
            $query->bindParam("biaya", $biaya, PDO::PARAM_INT);

            $query->execute();

            if ($query->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getSchoolStats($id)
    {
        $balance = $this->getSchoolTotalBalance($id);
        $users = $this->getSchoolUsersStats($id);
        $trx = $this->getSchoolTransactions($id);

        return (object)["balance" => $balance, "users" => $users, "trx" => $trx];
    }

    public function registerAdmin($nama, $email, $password, $id_sekolah)
    {
        try {
            $query = $this->cont->prepare(
                "INSERT INTO admin(nama, email, level, password, id_sekolah) 
                VALUES (:nama,:email,'admin',:password,:idsekolah)"
            );

            $enc_password = saltHash($password);

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
            $enc_password = saltHash($password);
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

            $enc_password = saltHash($password);

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

    public function addAdminJournal($id_admin, $code, $nilai, $ext1 = "")
    {
        try {
            $query = $this->cont->prepare(
                "INSERT INTO admin_journal(id_sekolah, id_admin, code, nilai, ext_1)
                VALUES (:idsekolah,:idadmin,:code,:nilai,:ext1)"
            );

            $query->bindParam("idsekolah", $this->getAdminById($id_admin, PDO::FETCH_OBJ)->id_sekolah, PDO::PARAM_INT);
            $query->bindParam("idadmin", $id_admin, PDO::PARAM_INT);
            $query->bindParam("code", $code, PDO::PARAM_STR);
            $query->bindParam("nilai", $nilai, PDO::PARAM_INT);
            $query->bindParam("ext1", $ext1, PDO::PARAM_STR);

            $query->execute();

            return $this->cont->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getAdminJournal($id_admin)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM admin_journal WHERE id_admin=:idadmin"
            );

            $query->bindParam("idadmin", $id_admin, PDO::PARAM_INT);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetchAll(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getAllUsers($idsekolah)
    {
        try {
            $stmt = $this->cont->prepare(
                "SELECT id, id_sekolah, tanggal_pendaftaran, nama, kelamin, email, level, tingkatan, kelas, jurusan, nisn, saldo 
                FROM users WHERE id_sekolah=:idsekolah ORDER BY id ASC"
            );

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

            $enc_password = saltHash($password);

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

            $id_siswa = $this->cont->lastInsertId();

            $queryspp = "INSERT INTO spp(id_sekolah, id_siswa, bulan) VALUES";

            $bulan = array('januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember');

            foreach ($bulan as $b) {
                $queryspp .= "('$id_sekolah', '$id_siswa', '$b')" . ($b != "desember" ? "," : "");
            }

            $this->cont->prepare($queryspp)->execute();

            return array($id_siswa, $password);
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function editUserFull($id, $nama, $id_sekolah, $kelamin, $email, $tingkatan, $kelas, $jurusan, $nisn)
    {
        try {
            $query = $this->cont->prepare(
                "UPDATE users
                SET nama=:nama,
                kelamin=:kelamin,
                email=:email,
                tingkatan=:tingkatan,
                kelas=:kelas,
                jurusan=:jurusan,
                nisn=:nisn WHERE id=:id AND id_sekolah=:idsekolah"
            );

            $query->bindParam("id", $id, PDO::PARAM_INT);
            $query->bindParam("idsekolah", $id_sekolah, PDO::PARAM_INT);
            $query->bindParam("nama", $nama, PDO::PARAM_STR);
            $query->bindParam("kelamin", $kelamin, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("tingkatan", $tingkatan, PDO::PARAM_STR);
            $query->bindParam("kelas", $kelas, PDO::PARAM_STR);
            $query->bindParam("jurusan", $jurusan, PDO::PARAM_STR);
            $query->bindParam("nisn", $nisn, PDO::PARAM_STR);

            $query->execute();

            return $query->rowCount();
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

            $enc_password = saltHash($password);

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

            $enc_password = saltHash($password);

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

    public function changeUserPassword($id, $old_password, $new_password)
    {
        try {
            $query = $this->cont->prepare(
                "UPDATE users SET password=IF(password=:old_password, :new_password, password) WHERE id=:id"
            );

            $old_password = saltHash($old_password);
            $new_password = saltHash($new_password);

            $query->bindParam("old_password", $old_password, PDO::PARAM_STR);
            $query->bindParam("new_password", $new_password, PDO::PARAM_STR);
            $query->bindParam("id", $id, PDO::PARAM_INT);

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
                "SELECT id, tanggal_pendaftaran, nama, email, level, tingkatan, kelas, jurusan, nisn, saldo
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
                "SELECT id, id_sekolah, tanggal_pendaftaran, nama, kelamin, email, level, tingkatan, kelas, jurusan, nisn, saldo 
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

    public function getUserByEmail($email, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT id, id_sekolah, tanggal_pendaftaran, nama, kelamin, email, level, tingkatan, kelas, jurusan, nisn, saldo 
                FROM users WHERE email=:email"
            );

            $query->bindParam("email", $email, PDO::PARAM_STR);

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
                "SELECT id, id_sekolah, tanggal_pendaftaran, nama, kelamin, email, level, tingkatan, kelas, jurusan, nisn, saldo 
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

    public function getUserSPPBill($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM spp WHERE id_siswa=:id AND status_pembayaran=0"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetchAll($rettype);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function getUserSPP($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM spp WHERE id_siswa=:id"
            );

            $query->bindParam("id", $id, PDO::PARAM_STR);

            $query->execute();

            if ($query->rowCount() > 0) {
                return $query->fetchAll($rettype);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function paySPP($userid, $schoolid, $sppid)
    {
        try {
            $sekolah = $this->getSchoolData($schoolid, PDO::FETCH_OBJ);
            $jumlah = $sekolah->biaya_spp;

            $query = $this->cont->prepare(
                "UPDATE schools
                SET saldo = saldo + :amount
                WHERE id=:idsekolah"
            );

            $query->bindParam("idsekolah", $schoolid, PDO::PARAM_STR);
            $query->bindParam("amount", $jumlah, PDO::PARAM_INT);

            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $query = $this->cont->prepare(
                "UPDATE users
                SET saldo = IF(:amount <= saldo, saldo - :amount, saldo)
                WHERE id=:userid"
            );

            $query->bindParam("userid", $userid, PDO::PARAM_STR);
            $query->bindParam("amount", $jumlah, PDO::PARAM_INT);

            $query->execute();


            if ($query->rowCount() < 0) {
                return false;
            }

            $query = $this->cont->prepare(
                "UPDATE spp SET status_pembayaran=1, tanggal_pembayaran=now() WHERE id=:id"
            );

            $query->bindParam("id", $sppid, PDO::PARAM_INT);

            $query->execute();

            return $query->rowCount();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function userDeposit($userid, $amount)
    {
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

    public function userWithdrawal($userid, $amount)
    {
        try {
            $query = $this->cont->prepare(
                "UPDATE users
                SET saldo = IF(:amount <= saldo, saldo - :amount, saldo)
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

    public function transferByNISN($userid, $nisn, $amount)
    {
        try {
            $query = $this->cont->prepare(
                "UPDATE users
                SET saldo = IF(:amount <= saldo, saldo - :amount, saldo)
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
            $query->bindParam(
                "idsekolah",
                $this->getAdminById($idposter, PDO::FETCH_OBJ)->id_sekolah,
                PDO::PARAM_INT
            );

            $query->execute();

            return $this->cont->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function chengeDonationStatus($id, $adminid, $status)
    {
        try {
            $query = $this->cont->prepare(
                "UPDATE donation SET status=:status WHERE id=:id AND id_sekolah=:idsekolah"
            );

            $query->bindParam("id", $id, PDO::PARAM_INT);
            $query->bindParam(
                "idsekolah",
                $this->getAdminById($adminid, PDO::FETCH_OBJ)->id_sekolah,
                PDO::PARAM_INT
            );
            $query->bindParam("status", $status, PDO::PARAM_STR);

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
                SET saldo = IF(:amount <= saldo, saldo - :amount, saldo)
                WHERE id=:userid"
            );

            $query->bindParam("userid", $user_id, PDO::PARAM_INT);
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

    public function disbursementDonation($donation_id, $admin_id, $amount)
    {
        try {
            $query = $this->cont->prepare(
                "UPDATE donation
                SET terkumpul = IF(:amount <= terkumpul, terkumpul - :amount, terkumpul)
                WHERE id=:donationid && id_sekolah=:idsekolah"
            );

            $query->bindParam("donationid", $donation_id, PDO::PARAM_STR);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);
            $query->bindParam("idsekolah", $this->getAdminById($admin_id, PDO::FETCH_OBJ)->id_sekolah, PDO::PARAM_INT);

            $query->execute();

            if ($query->rowCount() > 0) {
                return true;
            }
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

    public function getTransaction($id, $rettype)
    {
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
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function registerKantin($nama, $deskripsi, $id_sekolah)
    {
        try {
            $query = $this->cont->prepare(
                "INSERT INTO kantin(nama, deskripsi, id_sekolah)
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

    public function getKantin($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM kantin WHERE id=:id"
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

    public function getKantinList($id_sekolah, $rettype)
    {
        $stmt = $this->cont->prepare("SELECT * FROM kantin WHERE id_sekolah=:idsekolah");

        $stmt->bindParam("idsekolah", $id_sekolah, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll($rettype);
    }

    public function getTransaksiKantin($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM kantin_transaction WHERE kantin_id=:id ORDER BY id DESC"
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

    public function kantinWithdrawal($kantinid, $amount)
    {
        try {
            $query = $this->cont->prepare(
                "UPDATE kantin
                SET saldo = IF(:amount <= saldo, saldo - :amount, saldo)
                WHERE id=:kantinid"
            );

            $query->bindParam("kantinid", $kantinid, PDO::PARAM_STR);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);

            $query->execute();

            if ($query->rowCount() > 0) {
                return true;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function payKantin($userid, $uniqueid, $amount)
    {
        try {
            $QR = $this->getQR($uniqueid, PDO::FETCH_OBJ);

            $query = $this->cont->prepare(
                "UPDATE kantin
                SET saldo = saldo + :amount
                WHERE id=:idkantin"
            );

            $query->bindParam("idkantin", $QR->id_kantin, PDO::PARAM_STR);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);

            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $query = $this->cont->prepare(
                "UPDATE users
                SET saldo = IF(:amount <= saldo, saldo - :amount, saldo)
                WHERE id=:userid"
            );

            $query->bindParam("userid", $userid, PDO::PARAM_STR);
            $query->bindParam("amount", $amount, PDO::PARAM_INT);


            $query->execute();

            if ($query->rowCount() < 0) {
                return false;
            }

            $query = $this->cont->prepare(
                "INSERT INTO kantin_transaction(kantin_id, user_id, qr_id, jumlah, id_sekolah)
                VALUES (:kantinid,:userid,:qrid,:jumlah,:idsekolah)"
            );

            $query->bindParam("kantinid", $QR->id_kantin, PDO::PARAM_INT);
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

    public function newQr($judul, $nilai, $tetap, $id_admin, $id_kantin)
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
                "INSERT INTO qrcode(judul, nilai, tetap, generated_by, id_kantin, unique_id, id_sekolah)
                VALUES (:judul,:nilai,:tetap,:id_admin,:id_kantin,:id_unik,:idsekolah)"
            );

            $query->bindParam("judul", $judul, PDO::PARAM_STR);
            $query->bindParam("nilai", $nilai, PDO::PARAM_INT);
            $query->bindParam("tetap", $tetap, PDO::PARAM_BOOL);
            $query->bindParam("id_admin", $id_admin, PDO::PARAM_STR);
            $query->bindParam("id_kantin", $id_kantin, PDO::PARAM_STR);
            $query->bindParam("id_unik", $uniid, PDO::PARAM_STR);
            $query->bindParam("idsekolah", $this->getAdminById($id_admin, PDO::FETCH_OBJ)->id_sekolah, PDO::PARAM_INT);

            $query->execute();

            return $this->cont->lastInsertId();
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

    public function getQRById($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM qrcode WHERE id=:id"
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

    public function getQRCodeKantin($id, $rettype)
    {
        try {
            $query = $this->cont->prepare(
                "SELECT * FROM qrcode WHERE id_kantin=:id ORDER BY id DESC"
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
