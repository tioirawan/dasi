<?php
require "../db/database.php";

$db = new Database();

$pass = $db->register(
    $_POST["nama"],
    $_POST["kelamin"],
    $_POST["email"],
    $_POST["tingkatan"],
    $_POST["kelas"],
    $_POST["jurusan"],
    $_POST["nisn"],
    $_POST["saldo"]
)[1];

echo "Password: $pass<br/>Harap Diingat";
