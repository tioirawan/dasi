<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Dashboard</title>
</head>

<body>
    <?php include "../process/getAdminLoginData.php" ?>
    <?php include "../component/admin/sidebaropen.php" ?>

    <?php
    $sekolah = $db->getSchoolData($data["id_sekolah"], PDO::FETCH_OBJ);

    $stats = $db->getSchoolStats($data["id_sekolah"]);

    $trx = $stats->trx;

    $journal = $db->getAdminJournal($data["id"])

    // print_r($trx);
    ?>

    <h1>Dashobard</h1>

    <div class="row mt-3">
        <div class="col-sm-4 my-2">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><i class="fas fa-school pr-1"></i> <?= $sekolah->nama_sekolah ?> <span class="text-muted lead"><?= $sekolah->npsn ?></span></h3>
                    <p class="card-text lead">Siswa : <?= boldGreen(rupiah($stats->balance->siswa)) ?></p>
                    <p class="card-text lead">Toko : <?= boldGreen(rupiah($stats->balance->toko)) ?></p>
                    <p class="card-text lead">Dana Sosial : <?= boldGreen(rupiah($stats->balance->donasi)) ?></p>
                    <p class="card-text lead">Total : <?= boldGreen(rupiah($stats->balance->total)) ?></p>
                </div>
            </div>
        </div>

        <div class="col-sm-8 my-2">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Jumlah Akun Siswa</h3>
                    <div class="row">
                        <div class="col-sm-4 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><i class="fas fa-male" aria-hidden="true"></i> Laki-laki</h4>
                                    <p class="card-text"><?= $stats->users->laki ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><i class="fas fa-female"></i> Perempuan</h4>
                                    <p class="card-text"><?= $stats->users->perempuan ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><i class="fas fa-male"></i><i class="fas fa-female"></i> Total</h4>
                                    <p class="card-text"><?= $stats->users->total ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-sm-7">
            <h3>Seluruh Transaksi Siswa</h3>

            <?php if ($trx) { ?>
                <div class="table-responsive">
                    <table id="paymentHistoryTable" class="table">
                        <thead>
                            <tr>
                                <th>TRX ID</th>
                                <th>USER ID</th>
                                <th>Tanggal</th>
                                <th>Jenis</th>
                                <th>Debit</th>
                                <th>Kredit</th>
                                <th>Tipe</th>
                                <th>Metode</th>
                                <th>Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($trx as $val) {
                                ?>

                                <tr>
                                    <td><?= $val->id ?></td>
                                    <td><a href="detail_siswa.php?id=<?= $val->user_id ?>"><?= $val->user_id ?></a></td>
                                    <td><?= $val->tanggal ?></td>
                                    <td class="text-<?= $val->jenis == "masuk" ? "success" : "danger" ?>"><?= ucwords($val->jenis) ?></td>
                                    <td class="text-muted"><?= rupiah($val->debit) ?></td>
                                    <td class="text-<?= $val->jenis == "masuk" ? "success" : "danger" ?>"><?= rupiah($val->kredit) ?></td>
                                    <td><?= $val->tipe ?></td>
                                    <td><?= $val->metode ?></td>
                                    <td><?= ucwords($val->deskripsi) ?></td>
                                </tr>

                            <?php

                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <p>Belum terdapat transaksi</p>
            <?php } ?>
        </div>


        <div class="col-sm-5">
            <h3>Jurnal Admin</h3>

            <?php if ($journal) { ?>
                <div class="table-responsive">
                    <table id="adminJournalTable" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Nilai</th>
                                <th>EXT 1</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($journal as $val) {

                                preg_match('/\w(siswa|user)/', $val->code, $ext1siswa);
                                preg_match('/generate_qr_toko/', $val->code, $ext1qr);
                                preg_match('/tarik_tunai_toko/', $val->code, $ext1toko);
                                preg_match('/change_donation_status/', $val->code, $ext1donation);

                                ?>

                                <tr>
                                    <td><?= $val->id ?></td>
                                    <td><?= $val->tanggal ?></td>
                                    <td><?= $val->code ?></td>
                                    <td><?= $ext1donation ? $val->nilai : rupiah($val->nilai) ?></td>
                                    <td>
                                        <?php if (count($ext1siswa)) { ?>
                                            <a href='detail_siswa.php?id=<?= $val->ext_1 ?>'><?= $val->ext_1 ?></a>
                                        <?php } else if (count($ext1qr)) {
                                        $qr = $db->getQRById($val->ext_1, PDO::FETCH_OBJ);
                                        ?>
                                            <a href='info_toko.php?id=<?= $qr->id_toko ?>'><?= $val->ext_1 ?></a>
                                        <?php } else if (count($ext1donation)) { ?>
                                            <a href='infodonasi.php?id_donasi=<?= $val->ext_1 ?>'><?= $val->ext_1 ?></a>
                                        <?php } else if (count($ext1toko)) { ?>
                                            <a href='info_toko.php?id=<?= $val->ext_1 ?>'><?= $val->ext_1 ?></a>
                                        <?php } else { ?>
                                            <?= $val->ext_1 ?>
                                        <?php } ?>
                                    </td>
                                </tr>

                            <?php

                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <p>Belum terdapat aktifitas</p>
            <?php } ?>
        </div>
    </div>


    <?php include "../component/admin/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>

    <script>
        $(document).ready(function() {
            $('#paymentHistoryTable').DataTable({
                "order": [
                    [0, "desc"]
                ],
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ riwayat per halaman",
                    "zeroRecords": "Maaf, tidak dapat menemukan apapun",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Tidak ada riwayat yang dapat ditampilkan",
                    "infoFiltered": "(tersaring dari _MAX_ total riwayat)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    },
                }
            });

            $('#adminJournalTable').DataTable({
                "order": [
                    [0, "desc"]
                ],
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Maaf, tidak dapat menemukan apapun",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_ halaman",
                    "infoEmpty": "Tidak ada data yang dapat ditampilkan",
                    "infoFiltered": "(tersaring dari _MAX_ total data)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    },
                }
            });
        });
    </script>
</body>

</html>