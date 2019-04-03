<?php 
$trx = $db->getUserTransactionHistory($data["id"], PDO::FETCH_OBJ);

if ($trx) {

    foreach ($trx as $val) {
        ?>

<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title"><?= $val->deskripsi ?></h5>
        <p class="card-text"><?= indonesian_date($val->tanggal) ?></p>
        <h4 class="card-text mb-2 font-weight-bold float-sm-left text-<?= $val->jenis == "masuk" ? "success" : "danger" ?> mb-0">
            <?= $val->jenis == "masuk" ? "+" : "-" ?> <?= rupiah($val->kredit) ?>
        </h4>
        <p class="card-text font-weight-bold float-sm-right text-muted mb-0">
                <?= rupiah($val->debit) ?>
        </p>
    </div>
</div>

<!-- <tr>
    <td><?= $val->id ?></td>
    <td><?= $val->tanggal ?></td>
    <td><?= rupiah($val->jumlah) ?></td>
    <td><?= $val->tipe ?></td>
    <td><?= $val->metode ?></td>
    <td><?= $val->deskripsi ?></td>
</tr> -->

<?php
}

} else {
    echo "<p class='card-text'>Kamu belum melakukan transaksi apapun</p>";
}
?> 