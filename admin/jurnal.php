<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Jurnal Admin</title>
</head>

<body>
    <?php include "../process/getAdminLoginData.php" ?>
    <?php include "../component/admin/sidebaropen.php" ?>

    <?php        
        $journal = $db->getAdminJournal($data["id"])
    ?>

    <h1>Jurnal Admin</h1>

    <?php if ($journal) { ?>
        <div class="table-responsive mt-4">
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
                        preg_match('/tarik_spp/', $val->code, $ext1admin);

                        ?>

                        <tr>
                            <td><?= $val->id ?></td>
                            <td><?= $val->tanggal ?></td>
                            <td><?= $val->code ?></td>
                            <td data-sort="<?= $val->nilai ?>"><?= $ext1donation ? $val->nilai : rupiah($val->nilai) ?></td>
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

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>

    <script>
        $(document).ready(function() {
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