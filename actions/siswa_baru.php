<?php
require "../db/database.php";

$db = new Database();

$db->register(
    $_POST["nama"],
    $_POST["email"],
    "siswa",
    $_POST["tingkatan"],
    $_POST["kelas"],
    $_POST["jurusan"],
    $_POST["nisn"],
    $_POST["saldo"],
    $_POST["password"]
);
