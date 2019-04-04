<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">

<link rel="shortcut icon" type="image/x-icon" href="<?=__DIR__?>/../favicon.ico"/>

<?php 
    $up = file_exists('styles/bootstrap.css') ? '' : '../';
?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<link rel="stylesheet" href="<?=$up?>styles/bootstrap.css" > 
<link rel="stylesheet" href="<?=$up?>styles/bootstrapfix.css">

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sc-2.0.0/datatables.min.css"/>

<link rel="stylesheet" href="<?=$up?>styles/main.css">
<link rel="stylesheet" href="<?=$up?>styles/animation.css">
<link rel="stylesheet" href="<?=$up?>styles/sidebar.css">
 