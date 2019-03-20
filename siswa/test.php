<?php 
     require '../db/database.php';

     $pdo = new Database();

     print_r($pdo->registerAdmin("admin", "admin@mail.com", "admin123"));
?>