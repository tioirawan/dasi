<?php
require "checkpost.php";
require "../db/database.php";

$db = new Database();

$res = $db->registerSchool(
    $_POST["nama_sekolah"],
    $_POST["npsn_sekolah"],
    $_POST["status"],
    $_POST["bentuk_pendidikan"],
    $_POST["alamat"],
    $_POST["email_sekolah"],
    isset($_POST["kode"])
);

if ($res) { ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include "../component/helmet.php" ?>
        <title>SPP</title>
    </head>

    <body>

        <div class="card">
            <div class="card-body">
                <h1>Daftarkakn Pengurus Sekolah</h1>

                <form action="register_admin.php" method="post" class="mt-4">
                    <div class="form-group">
                        <label for="nama">Nama Pengurus</label>
                        <input type="text" name="nama" id="nama" class="form-control input-sm" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                        <input type="password" name="password" id="password" class="form-control input-sm" required>
                    </div>

                    <input type="hidden" name="idsekolah" value="<?= $res ?>">

                    <input type="submit" value="Selesai" class="btn btn-primary">
                </form>
            </div>
        </div>


        <?php include "../component/scripts.php" ?>

    </body>

    </html>

<?php
} else {
    echo "<div class='container text-center'>";
    echo "<h1>Maaf Tidak Dapat Mendaftarkan Sekolah, terjadi kesalahan</h1>";
    echo "<button onclick='history.back()' class='btn btn-primary'>Kembali</button>";
    echo "</div>";

    return;
}
?>