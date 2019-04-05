<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Siswa Baru</title>
</head>

<body>
    <?php include "../process/getAdminLoginData.php" ?>
    <?php include "../component/admin/sidebaropen.php" ?>

    <h1>Form Akun Siswa Baru</h1>

    <form action="../actions/siswa_baru.php" method="post">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="nama_siswa">Nama Siswa</label>
                    <input type="text" class="form-control" name="nama" id="nama_siswa" placeholder="Hafizh Beckham" required>
                </div>

                <div class="form-group">
                    <label for="kelamin">Kelamin Siswa</label>
                    <select class="form-control" id="kelamin" name="kelamin" required>
                        <option value="laki-laki">Laki-Laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label for="email_siswa">Email Siswa</label>
                    <input type="email" class="form-control" name="email" id="email_siswa" placeholder="hafizh@beckham.me" required>
                </div>

                <div class="form-group">
                    <label for="tingkatan">Tingkatan Siswa</label>
                    <select class="form-control" id="tingkatan" name="tingkatan" required>
                        <option value="I">I</option>
                        <option value="II">II</option>
                        <option value="III">III</option>
                        <option value="IV">IV</option>
                        <option value="V">V</option>
                        <option value="VI">VI</option>
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

            <div class="col-sm-3">
                <div class="form-group">
                    <label for="kelas_siswa">Kelas Siswa</label>
                    <input type="text" class="form-control" name="kelas" id="kelas_siswa" placeholder="A/B/C" required>
                </div>

                <div class="form-group">
                    <label for="jurusan_siswa">Jurusan Siswa</label>
                    <input type="text" class="form-control" name="jurusan" id="jurusan_siswa" placeholder="RPL" required>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="form-group">
                    <label for="nisn_siswa">NISN Siswa</label>
                    <input type="text" class="form-control" name="nisn" id="nisn_siswa" placeholder="1234567890" required>
                </div>

                <div class="form-group">
                    <label for="saldo_awal_siswa">Sadlo Awal Siswa</label>
                    <input type="number" class="form-control uang" name="saldo" id="saldo_awal_siswa" value="0" required>
                </div>
            </div>
        </div>

        <input type="hidden" name="idsekolah" value="<?=$data["id_sekolah"]?>">

        <input type="submit" class="btn btn-primary" value="Masukan">
    </form>

    </div>



    <?php include "../component/admin/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html> 