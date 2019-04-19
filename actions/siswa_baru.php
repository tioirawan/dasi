<?php
require "checkpost.php";
require "../db/database.php";

$db = new Database();

$res = $db->register(
    $_POST["nama"],
    $_POST["idsekolah"],
    $_POST["kelamin"],
    $_POST["email"],
    $_POST["tingkatan"],
    $_POST["kelas"],
    $_POST["jurusan"],
    $_POST["nisn"],
    $_POST["saldo"]
);

$db->addAdminJournal($_POST["adminid"], "register_siswa", 0, $res[0]);

echo "Password: $res[1]<br/>Harap Diingat";
