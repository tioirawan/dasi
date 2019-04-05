<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>History</title>
</head>

<body>
    <?php include "../process/getAdminLoginData.php" ?>
    <?php include "../component/admin/sidebaropen.php" ?>

    <div class="card">
        <div class="card-body">
            <h1 class="card-title">Siswa
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#tambah_siswa">Tambah Siswa</button>
            </h1>

            <div class="collapse mb-4" id="tambah_siswa">
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

            <div class="card card-body">
                <?php 
                $users = $db->getAllUsers($data["id_sekolah"]);

                if ($users) {
                    ?>

                <div class="table-responsive">
                    <table id="listSiswa" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Kelamin</th>
                                <th>Email</th>
                                <th>Kelas</th>
                                <th>NISN</th>
                                <th>Saldo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($users as $siswa) {
                                ?>

                            <tr>
                                <td><?= $siswa->id ?></td>
                                <td><?= ucwords($siswa->nama) ?></td>
                                <td><?= $siswa->kelamin ?></td>
                                <td><?= $siswa->email ?></td>
                                <td><?= "$siswa->tingkatan $siswa->jurusan $siswa->kelas" ?></td>
                                <td><?= $siswa->nisn ?></td>
                                <td><?= rupiah($siswa->saldo) ?></td>
                                <td><a href="detail_siswa.php?id=<?=$siswa->id?>" class="btn btn-primary">Detail</a></td>
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
            </div>
        </div>

    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>

    <script>
        $(document).ready(function() {
            $('#listSiswa').DataTable();
        });
    </script>
</body>

</html> 