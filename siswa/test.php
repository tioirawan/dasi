<?php 
     require '../db/database.php';

     $pdo = new Database();

     print_r($pdo->getAllUsers());
?>