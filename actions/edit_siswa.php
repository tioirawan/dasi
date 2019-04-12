<?php
require "checkpost.php";
require "../db/database.php";

$db = new Database();

$pass = $db->editUserFull(
    $_POST["id"],
    $_POST["nama"],
    $_POST["idsekolah"],
    $_POST["kelamin"],
    $_POST["email"],
    $_POST["tingkatan"],
    $_POST["kelas"],
    $_POST["jurusan"],
    $_POST["nisn"]
);

$db->addAdminJournal($_POST["adminid"], "edit_user", 0, $_POST["id"]);

header("Location: ../admin/detail_siswa.php?id=".$_POST["id"]);
die();
