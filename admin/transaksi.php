<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Transaksi Siswa</title>
</head>

<body>
    <?php include "../process/getAdminLoginData.php" ?>
    <?php include "../component/admin/sidebaropen.php" ?>

    <?php
        $trx = $db->getSchoolTransactions($data["id_sekolah"]);;
    ?>

    <h1>Transaksi Siswa</h1>

    <?php if ($trx) { ?>
        <div class="table-responsive mt-4">
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
                            <td class="text-muted" data-sort="<?=$val->debit?>"><?= rupiah($val->debit) ?></td>
                            <td class="text-<?= $val->jenis == "masuk" ? "success" : "danger" ?>" data-sort="<?=$val->kredit?>"><?= rupiah($val->kredit) ?></td>
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

    <?php include "../component/siswa/sidebarclose.php" ?>
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
        });
    </script>
</body>

</html> 