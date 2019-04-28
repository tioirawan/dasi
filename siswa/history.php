<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>History</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <h1 class="card-title">Riwayat Transaksi <button class="btn btn-primary" onclick="printHistory()"><i class="fa fa-print" aria-hidden="true"></i></button></h1>

    <?php
    $trx = $db->getUserTransactionHistory($data["id"], PDO::FETCH_OBJ);

    // print_r($trx);

    if ($trx) {
        ?>

        <div class="table-responsive" id="container-history">
            <table id="paymentHistoryTable" class="table">
                <thead>
                    <tr>
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
                            <td><?= $val->tanggal ?></td>
                            <td class="text-<?= $val->jenis == "masuk" ? "success" : "danger" ?>"><?= ucwords($val->jenis) ?></td>
                            <td class="text-muted" data-sort="<?= $val->debit ?>"><?= rupiah($val->debit) ?></td>
                            <td class="text-<?= $val->jenis == "masuk" ? "success" : "danger" ?>" data-sort="<?= $val->kredit ?>"><?= rupiah($val->kredit) ?></td>
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

    <?php

} else {
    echo "<p class='card-text'>Kamu belum melakukan transaksi apapun</p>";
}
?>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
    <?php require "../component/scrollTop.php" ?>

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

        function printHistory() {
            var centeredText = function(text, y) {
                var textWidth = pdf.getStringUnitWidth(text) * pdf.internal.getFontSize() / pdf.internal.scaleFactor;
                var textOffset = (pdf.internal.pageSize.width - textWidth) / 2;
                pdf.text(textOffset, y, text);
            }

            var pdf = new jsPDF('p', 'pt', 'letter');

            pdf.setFontType("normal");
            
            centeredText("Riwayat Transaksi: <?= "{$data["nama"]} - {$data["tingkatan"]} {$data["jurusan"]} {$data["kelas"]}" ?>", 30);

            pdf.autoTable({
                html: "#paymentHistoryTable"
            });

            pdf.save('history-<?= $data["nama"] ?>.pdf');
        }
    </script>
</body>

</html>