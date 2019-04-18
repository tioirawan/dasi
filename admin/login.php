<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Login Admin</title>
</head>

<body>
    <?php include "../process/redirectLoggedUser.php" ?>
    
    <center>
        <div class="container">
            <h1>Masuk Admin</h1>

            <div class="login">
                <form action="../actions/login_admin.php" method="POST">
                    <div class="form-group">
                        <label for="useremail">Email</label>
                        <input type="email" name="useremail" class="form-control" id="useremail" placeholder="Email">

                    </div>
                    <div class="form-group">
                        <label for="userpass">Kata Sandi</label>
                        <input type="password" name="userpass" class="form-control" id="userpass" placeholder="Kata Sandi">
                    </div>

                    <!-- <div class="right-left"> -->
                    <!-- <div class="form-check">
                            <input type="checkbox" name="rememberme" class="form-check-input" id="rememberme">
                            <label class="form-check-label" for="rememberme">Ingat Saya</label>
                        </div> -->

                    <div class="right-left">
                        <div>
                            <a href="../" class="btn btn-primary">Kembali</a>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-success">Masuk</button>                                
                        </div>
                    </div>
                    <!-- </div> -->
                </form>
            </div>
        </div>
    </center>
    
</body>

</html> 