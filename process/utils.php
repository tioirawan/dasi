<?php
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

function boldGreen($str) {
    return "<span class='lead text-success'>$str</span>";
}

function namaDepan($nama) {
    return explode(" ", $nama)[0];
}

function indonesian_date($timestamp = '', $date_format = 'd F Y', $suffix = '')
{
    if ($timestamp == null)
        return '-';

    if ($timestamp == '1970-01-01' || $timestamp == '0000-00-00' || $timestamp == '-25200')
        return '-';


    if (trim($timestamp) == '') {
            $timestamp = time();
        } elseif (!ctype_digit($timestamp)) {
            $timestamp = strtotime($timestamp);
        }
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
    $date_format = preg_replace("/S/", "", $date_format);
    $pattern = array(
        '/Mon[^day]/', '/Tue[^sday]/', '/Wed[^nesday]/', '/Thu[^rsday]/',
        '/Fri[^day]/', '/Sat[^urday]/', '/Sun[^day]/', '/Monday/', '/Tuesday/',
        '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/',
        '/Jan[^uary]/', '/Feb[^ruary]/', '/Mar[^ch]/', '/Apr[^il]/', '/May/',
        '/Jun[^e]/', '/Jul[^y]/', '/Aug[^ust]/', '/Sep[^tember]/', '/Oct[^ober]/',
        '/Nov[^ember]/', '/Dec[^ember]/', '/January/', '/February/', '/March/',
        '/April/', '/June/', '/July/', '/August/', '/September/', '/October/',
        '/November/', '/December/',
    );
    $replace = array(
        'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min',
        'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu',
        'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des',
        'Januari', 'Februari', 'Maret', 'April', 'Juni', 'Juli', 'Agustus', 'September',
        'Oktober', 'November', 'Desember',
    );
    $date = date($date_format, $timestamp);
    $date = preg_replace($pattern, $replace, $date);
    $date = "{$date} {$suffix}";
    return $date;
}

function generateRandom($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function sendMail($mto, $msubject, $mbody)
{
    /* Source: http://www.apphp.com/index.php?snippet=php-get-remote-ip-address */

    $to = $mto;
    $subject = $msubject;
    $body = $mbody;
    $headers = 'From: Dasi' . "\r\n";
    $headers .= 'Reply-To: noreply@dasi.com' . "\r\n";
    $headers .= 'Return-Path: noreplay@dasi.com' . "\r\n";
    $headers .= 'X-Mailer: PHP7' . "\n";
    $headers .= 'MIME-Version: 1.0' . "\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    mail($to, $subject, $body, $headers);
}
