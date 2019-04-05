<?php
require "../db/database.php";

$db = new Database();

$res = $db->registerSchool(
    $_POST["npsn"],
    $_POST["status"],
    $_POST["bentuk_pendidikan"],
    $_POST["nama_sekolah"]
);

