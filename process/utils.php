<?php
function rupiah($angka) {
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function generateRandom($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    
    return $randomString;
}

function sendMail($mto, $msubject, $mbody) {
    /* Source: http://www.apphp.com/index.php?snippet=php-get-remote-ip-address */

    $to = $mto;
    $subject = $msubject;
    $body = $mbody;
    $headers = 'From: Dasi'."\r\n";
    $headers .= 'Reply-To: noreply@dasi.com'."\r\n";
    $headers .= 'Return-Path: noreplay@dasi.com'."\r\n";
    $headers .= 'X-Mailer: PHP7'."\n";
    $headers .= 'MIME-Version: 1.0'."\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";

    mail($to, $subject, $body, $headers);
}
