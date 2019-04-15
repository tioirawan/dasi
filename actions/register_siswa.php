<?php
require "checkpost.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>SPP</title>
</head>

<body>
    <?php
    include "../db/database.php";

    $db = new Database();

    $sekolah = $db->getSchoolByCode($_POST["kode_sekolah"], PDO::FETCH_OBJ);
    $checkSiswa = $db->getUserByEmail($_POST["email"], PDO::FETCH_OBJ);

    if (!$sekolah) {
        echo "<div class='container text-center'>";
        echo "<h1>Maaf Tidak Dapat Menemukan Kode Sekolah</h1>";
        echo "<button onclick='history.back()' class='btn btn-primary'>Kembali</button>";
        echo "</div>";

        return;
    }

    if ($checkSiswa) {
        echo "<div class='container text-center'>";
        echo "<h1>Maaf Email Telah Digunakan</h1>";
        echo "<button onclick='history.back()' class='btn btn-primary'>Kembali</button>";
        echo "</div>";

        return;
    }

    $res = $db->register(
        $_POST["nama"],
        $sekolah->id,
        $_POST["kelamin"],
        $_POST["email"],
        $_POST["tingkatan"],
        $_POST["kelas"],
        $_POST["jurusan"],
        $_POST["nisn"],
        0
    );

    ?>


    <div class="card">
        <div class="card-body">
            <form action="../actions/ubah_password.php" method="post" class="validatedForm">
                <h1>Atur Kata Sandi</h1>

                <div class="form-group">
                    <label for="old_password">Password saat ini</label>
                    <input type="text" name="old_password" id="old_password" class="form-control mb-1" value="<?= $res[1] ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="new_password">Password baru</label>
                    <input type="password" name="new_password" id="new_password" class="form-control mb-1">
                </div>

                <div class="form-group">
                    <label for="new_password_confirm">Konfirmasi password baru</label>
                    <input type="password" name="new_password_confirm" id="new_password_confirm" class="form-control mb-1">
                </div>

                <input type="hidden" name="id" value="<?= $res[0] ?>">

                <input type="submit" class="btn btn-primary" value="ubah">
            </form>
        </div>
    </div>


    <?php include "../component/scripts.php" ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>

    <script>
        $('.validatedForm').validate({
            rules: {
                old_password: {
                    minlength: 6
                },
                new_password: {
                    minlength: 6
                },
                new_password_confirm: {
                    minlength: 6,
                    equalTo: "#new_password"
                }
            },
            messages: {
                old_password: {
                    minlength: "Password setidaknya 6 karakter"
                },
                new_password: {
                    minlength: "Password setidaknya 6 karakter"
                },
                new_password_confirm: {
                    minlength: "Password setidaknya 6 karakter",
                    equalTo: "Password tidak cocok"
                }
            }
        });

        $('.validatedForm').submit(() => $('.validatedForm').valid())
    </script>
</body>

</html>