<?php
function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $hasil_rupiah;
}

$data = array(
    "nama" => "Ardiva Tri Akbar",
    "nisn" => "0021413121",
    "level" => "siswa",
    "saldo" => "110000",
);
 