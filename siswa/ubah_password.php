<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>SPP</title>
</head>

<body>
    <?php include "../process/getLoginData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <div class="card">
        <div class="card-body">
            <form action="../actions/ubah_password.php" method="post" class="validatedForm">
                <div class="form-group">
                    <label for="old_password">Password saat ini</label>
                    <input type="password" name="old_password" id="old_password" class="form-control mb-1">
                </div>

                <div class="form-group">
                    <label for="new_password">Password baru</label>
                    <input type="password" name="new_password" id="new_password" class="form-control mb-1">
                </div>

                <div class="form-group">
                    <label for="new_password_confirm">Konfirmasi password baru</label>
                    <input type="password" name="new_password_confirm" id="new_password_confirm" class="form-control mb-1">
                </div>

                <input type="hidden" name="id" value="<?=$data["id"]?>">

                <input type="submit" class="btn btn-primary" value="ubah">
            </form>
        </div>
    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
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