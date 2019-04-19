<?php
session_start();

require __DIR__ . '/../db/database.php';

if (isset($_SESSION['siswaid'])) {
    header("Location: ../siswa/dashboard.php");
    die();
} else if (isset($_SESSION['adminid'])) {
    header("Location: ../admin/dashboard.php");
    die();
}
