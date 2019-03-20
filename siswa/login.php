<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Document</title>
</head>

<body>
    <center>
        <div class="container">
            <h1>Masuk</h1>

            <div class="login">
                <form action="actions/login.php" method="POST">
                    <div class="form-group">
                        <label for="userinput">Nama Pengguna</label>
                        <input type="text" name="username" class="form-control" id="userinput" aria-describedby="emailHelp" placeholder="Nama Pengguna">

                    </div>
                    <div class="form-group">
                        <label for="userpass">Kata Sandi</label>
                        <input type="password" name="userpass" class="form-control" id="userpass" placeholder="Kata Sandi">
                    </div>

                    <div class="right-left">
                        <div class="form-check">
                            <input type="checkbox" name="rememberme" class="form-check-input" id="rememberme">
                            <label class="form-check-label" for="rememberme">Ingat Saya</label>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">Masuk</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </center>
    <?php include "component/footer.php" ?>
</body>

</html> 