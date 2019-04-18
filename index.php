<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'component/helmet.php' ?>

    <link rel="stylesheet" href="styles/landing.css">

    <title>Dasi</title>
</head>

<body id="blog">
    <a id="move-top" class="animate-move-top" href="#blog">
        <li class="fa fa-angle-up"></li>
    </a>
    <?php
    session_start();

    require 'db/database.php';

    if (isset($_SESSION['userid'])) {
        header("Location: siswa/dashboard.php");
        die();
    } else if (isset($_SESSION['adminid'])) {
        header("Location: admin/dashboard.php");
        die();
    }

    ?>


    <nav class="navbar fixed-top white navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#"> <img src="assets/logo_colored.svg" width="30" height="30" class="d-inline-block align-top" alt=""></a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Login
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="siswa/login.php">Siswa</a>
                        <a class="dropdown-item" href="admin/login.php">Sekolah</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link pointer" id="daftar-sekolah">Daftar Sekolah</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pointer" id="daftar-siswa">Daftar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Tentang</a>
                </li>
            </ul>
        </div>
    </nav>


    <header class="masthead">
        <div class="container h-100">

            <div class="row h-100 align-items-center">
                <div class="col-12 text-left brand-container">
                    <h1 class="font-weight-light">Dasi</h1>
                    <p class="lead">Dana Siswa</p>
                </div>
            </div>
        </div>
    </header>


    <section class="py-5">
        <div class="container">
            <div class="container text-center py-2">
                <h2 class="font-weight-light">Apa itu Dasi?</h2>
                <p>Dasi adalah sebuah dompet elektronik yang dikhususkan di lingkungan
                    sekolah. Siswa dapat menabung, membayar di kantin, SPP, Dansos, dan lainya dengan
                    mudah dan cepat. Orang tua juga dapat mengawasi riwayat transaksi siswa.</p>
            </div>

            <div class="container text-center py-2">
                <h2 class="font-weight-light">Fitur Utama Dasi</h2>
                <div class="row">
                    <div class="col-sm-4 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-qrcode" aria-hidden="true"></i> Kode QR</h5>
                                <p class="card-text">Bayar di kantin atau transfer saldo dengan Kode QR yang tersedia</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 pt-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-hand-holding-usd"></i> Donasi</h5>
                                <p class="card-text">Siswa dapat berdonasi dengan cepat dan mudah menggunakan dasi</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 py-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-file-invoice"></i> SPP</h5>
                                <p class="card-text">Bayar SPP dengan cepat dan mudah tanpa antri tanpa harus pergi ke TU</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container py-2 text-center form-daftar-sekolah">
                <h2 class="font-weight-light">Pendaftaran Sekolah</h2>

                <p>Ayo, daftarkan sekolah anda dan nikmati kemudahanya!</p>

                <form action="actions/daftar_sekolah.php" method="post" class="mt-4">
                    <div class="form-group">
                        <label for="nama_sekolah">Nama Sekolah</label>
                        <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control input-sm" required>
                    </div>

                    <div class="form-group">
                        <label for="email_sekolah">Email Sekolah</label>
                        <input type="email" name="email_sekolah" id="email_sekolah" class="form-control input-sm" required>
                    </div>

                    <div class="form-group">
                        <label for="npsn_sekolah">NPSN</label>
                        <input type="number" name="npsn_sekolah" id="npsn_sekolah" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="negeri">Negeri</option>
                            <option value="swasta">Swasta</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bentuk_pendidikan">Bentuk Pendidikan</label>
                        <select class="form-control" id="bentuk_pendidikan" name="bentuk_pendidikan" required>
                            <option value="SMP">SMP</option>
                            <option value="MTS">MTS</option>
                            <option value="SMK">SMK</option>
                            <option value="SMA">SMA</option>
                            <option value="MA">MA</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control" required>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="kode" name="kode">
                        <label class="form-check-label" for="kode">Perbolehkan Siswa Mendaftar Sendiri</label>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Daftarkan</button>
                </form>
            </div>

            <div class="container py-2 text-center form-daftar-siswa">
                <h2 class="font-weight-light">Pendaftaran Siswa</h2>

                <form action="actions/register_siswa.php" method="post">
                    <div>
                        <div class="form-group">
                            <label for="kode_sekolah">Kode Sekolah</label>
                            <input type="text" class="form-control" name="kode_sekolah" id="kode_sekolah" required>
                        </div>

                        <div class="form-group">
                            <label for="nama_siswa">Nama</label>
                            <input type="text" class="form-control" name="nama" id="nama_siswa" required>
                        </div>

                        <div class="form-group">
                            <label for="kelamin">Kelamin</label>
                            <select class="form-control" id="kelamin" name="kelamin" required>
                                <option value="laki-laki">Laki-Laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="email_siswa">Email</label>
                            <input type="email" class="form-control" name="email" id="email_siswa" required>
                        </div>

                        <div class="form-group">
                            <label for="tingkatan">Tingkatan</label>
                            <select class="form-control" id="tingkatan" name="tingkatan" required>
                                <!-- <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                    <option value="VI">VI</option> -->
                                <option value="VII">VII</option>
                                <option value="VIII">VIII</option>
                                <option value="IV">IV</option>
                                <option value="X" selected>X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                                <option value="XIII">XIII</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="kelas_siswa">Kelas</label>
                            <input type="text" class="form-control" name="kelas" id="kelas_siswa" required>
                        </div>

                        <div class="form-group">
                            <label for="jurusan_siswa">Jurusan</label>
                            <input type="text" class="form-control" name="jurusan" id="jurusan_siswa" required>
                        </div>
                    </div>

                    <div>
                        <div class="form-group">
                            <label for="nisn_siswa">NISN</label>
                            <input type="text" class="form-control" name="nisn" id="nisn_siswa" required>
                        </div>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Masukan">
                </form>
            </div>
        </div>
    </section>


    <footer class="page-footer font-small blue pt-4">
        <div class="container-fluid text-center">
            <h5 class="text-uppercase">Dasi</h5>
            <p>Situs web ini hanyalah prototype untuk Permata Youthpreneur</p>
        </div>

        <div class="footer-copyright text-center py-3">© 2018 Copyright:
            <a href="https://www.smkn8malang.sch.id/"> $_BASH - SMKN 8 Malang</a>
        </div>

    </footer>

    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        $("#daftar-sekolah").on("click", () => {
            $('html, body').animate({
                    scrollTop: $('.form-daftar-sekolah').offset().top - 60
                },
                1000
            );
        })

        $("#daftar-siswa").on("click", () => {
            $('html, body').animate({
                    scrollTop: $('.form-daftar-siswa').offset().top - 60
                },
                1000
            );
        })
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("move-top").style.display = "block";
            } else {
                document.getElementById("move-top").style.display = "none";
            }
        }
        $("a[href='#blog']").click(function() {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            return false;
        });
    </script>
</body>

</html>