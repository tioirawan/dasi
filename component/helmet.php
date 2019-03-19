<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<?php 
    $depth = explode('/', $_SERVER['REQUEST_URI'])[1];
    $up = $depth == "siswa" || $depth == "admin" ? '../' : '';
?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<link rel="stylesheet" href="<?=$up?>styles/bootstrap.css" > 
<link rel="stylesheet" href="<?=$up?>styles/bootstrapfix.css">
<link rel="stylesheet" href="<?=$up?>styles/main.css">
<link rel="stylesheet" href="<?=$up?>styles/sidebar.css">


