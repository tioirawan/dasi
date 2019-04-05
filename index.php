<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Dasi</title>
</head>

<body>
    <?php 
    session_start();

    require 'db/database.php';

    if (isset($_SESSION['userid'])) {
        header("Location: siswa/dashboard.php");
        die();
    } else if (isset($_SESSION['adminid'])) {
        header("Location: admin/dashboard.php");
        die();
    }
    
    ?>

    <header>
        <h1>DASI</h1>
        <a href="siswa/login.php">login siswa</a>
        <a href="admin/login.php">login admin</a>
    </header>
</body>

</html> 