<?php
require "../db/database.php";

$db = new Database();

$success = false;

$validated = $db->validatePassword($_POST["id"], $_POST["old_password"]);

if ($validated) {
    if ($db->changeUserPassword(
        $_POST["id"],
        $_POST["old_password"],
        $_POST["new_password"]
    )) {
        $success = true;
        header("Location: ../siswa/ubah_password.php?");
        die();
    }
} else {
    echo "Password salah";
}
