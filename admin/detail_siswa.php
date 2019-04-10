<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>

    <title>Detail Siswa</title>
</head>

<body>
    <?php include "../process/getAdminLoginData.php" ?>
    <?php include "../component/admin/sidebaropen.php" ?>

    <?php if (isset($_GET["ssc"])) { ?>
        <div class="modal" id="sccModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content bg-primary text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <?= $_GET["ssc"] ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
                } ?>

    <?php
                $siswa = $db->getUserById($_GET["id"], PDO::FETCH_OBJ);
                ?>

    <div class="row">
        <div class="col-md-5">
            <h1><i class="fas fa-user"></i> <?= $siswa->nama ?></h1>

            <div class="my-4">
                <h3><?= rupiah($siswa->saldo) ?></h3>
            </div>

            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header pointer" data-toggle="collapse" data-target="#collapseOne" id="headingOne">
                        <h5 class="mb-0">
                            <button class="btn" type="button">
                                Data Siswa
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            <table class="table">
                                <tr>
                                    <th>Nama</th>
                                    <td><?= $siswa->nama ?></td>
                                </tr>
                                <tr>
                                    <th>NISN</th>
                                    <td><?= $siswa->nisn ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= $siswa->email ?></td>
                                </tr>
                                <tr>
                                    <th>Kelamin</th>
                                    <td><?= $siswa->kelamin ?></td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td><?= "$siswa->tingkatan $siswa->jurusan $siswa->kelas" ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header pointer" data-toggle="collapse" data-target="#collapseTwo" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn collapsed" type="button">
                                Edit Siswa
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="../actions/edit_siswa.php" method="post">
                            <p class="text-danger font-italic">*Hati-hati dan pastikan kembali jika mengubah data siswa, salah mengubah data siswa dapat menyebabkan hal yang tidak diinginkan</p>
                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="nama_siswa">Nama Siswa</label>
                                            <input type="text" value="<?= $siswa->nama ?>" class="form-control" name="nama" id="nama_siswa" placeholder="Hafizh Beckham" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="kelamin">Kelamin Siswa</label>
                                            <select class="form-control" id="kelamin" name="kelamin" required>
                                                <option value="laki-laki" <?=$siswa->kelamin == "laki-laki" ? "selected" : "" ?>>Laki-Laki</option>
                                                <option value="perempuan" <?=$siswa->kelamin == "perempuan" ? "selected" : "" ?>>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="email_siswa">Email Siswa</label>
                                            <input type="email" value="<?= $siswa->email ?>" class="form-control" name="email" id="email_siswa" placeholder="hafizh@beckham.me" required>
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
                                                <option value="VII" <?= $siswa->tingkatan == "VII" ? "selected" : "" ?>>VII</option>
                                                <option value="VIII" <?= $siswa->tingkatan == "VIII" ? "selected" : "" ?>>VIII</option>
                                                <option value="IV" <?= $siswa->tingkatan == "IV" ? "selected" : "" ?>>IV</option>
                                                <option value="X" <?= $siswa->tingkatan == "X" ? "selected" : "" ?>>X</option>
                                                <option value="XI" <?= $siswa->tingkatan == "XI" ? "selected" : "" ?>>XI</option>
                                                <option value="XII" <?= $siswa->tingkatan == "XII" ? "selected" : "" ?>>XII</option>
                                                <option value="XIII" <?= $siswa->tingkatan == "XIII" ? "selected" : "" ?>>XIII</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="kelas_siswa">Kelas Siswa</label>
                                            <input type="text" value="<?= $siswa->kelas ?>" class="form-control" name="kelas" id="kelas_siswa" placeholder="A/B/C" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="jurusan_siswa">Jurusan Siswa</label>
                                            <input type="text" value="<?= $siswa->jurusan ?>" class="form-control" name="jurusan" id="jurusan_siswa" placeholder="RPL" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="nisn_siswa">NISN Siswa</label>
                                            <input type="text" value="<?= $siswa->nisn ?>" class="form-control" name="nisn" id="nisn_siswa" placeholder="1234567890" required>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="idsekolah" value="<?= $data["id_sekolah"] ?>">
                                <input type="hidden" name="id" value="<?= $siswa->id ?>">
                                <input type="hidden" name="adminid" value="<?= $data["id"] ?>">

                                <input type="submit" class="btn btn-primary" value="Update">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card my-3" id="card-wrapper">
                <div class="card-body">
                    <a href="siswa.php" class="btn btn-primary">
                        Daftar Siswa
                    </a>

                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTransaksi">
                        Transaksi
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="modalTransaksi" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Transaksi</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <?php
                                            $trx = $db->getUserTransactionHistory($siswa->id, PDO::FETCH_OBJ);

                                            if ($trx) {
                                                ?>

                                                <div class="table-responsive">
                                                    <table id="paymentHistoryTable" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
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
                                                        <td><?= $val->id ?></td>
                                                    <td><?= $val->tanggal ?></td>
                                                    <td><?= ucwords($val->jenis) ?></td>
                                                    <td><?= rupiah($val->debit) ?></td>
                                                    <td><?= rupiah($val->kredit) ?></td>
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
                                                echo "<p class='card-text'>Belum melakukan transaksi</p>";
                                            }
                                            ?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card p-4 my-3" id="setor_tunai">
                <h3>Setor Tunai</h3>

                <form action="../actions/setor_tunai_siswa.php" method="post">
                    <div class="form-group">
                        <label for="jumlah_penyetoran">Jumlah Penyetoran</label>

                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" class="form-control uang" name="nominal_setor" id="jumlah_penyetoran" min="1000" value="1000" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi_penyetoran">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" value="Setor Tunai" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password Admin</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <input type="hidden" name="userid" value="<?= $siswa->id ?>">
                    <input type="hidden" name="adminid" value="<?= $data["id"] ?>">

                    <input type="submit" class="btn btn-primary" value="Setor">
                </form>
            </div>

            <div class="card p-4 my-3" id="tarik_tunai">
                <h3>Tarik Tunai</h3>

                <form action="../actions/tarik_tunai_siswa.php" method="post">

                    <div class="form-group">
                        <label for="jumlah_penarikan">Jumlah Penarikan</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" class="form-control uang" name="nominal_tarik" id="jumlah_penarikan" min="1" max="<?=$siswa->saldo?>" value="10000" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi_penyetoran">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" value="Tarik Tunai" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password Admin</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <input type="hidden" name="userid" value="<?= $siswa->id ?>">
                    <input type="hidden" name="adminid" value="<?= $data["id"] ?>">

                    <input type="submit" class="btn btn-primary" value="Tarik">
                </form>
            </div>
        </div>
    </div>


    <?php include "../component/admin/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>

    <script>
        <?php if (isset($_GET["ssc"])) { ?>
            $(window).on('load', function() {
                $('#sccModal').modal('show');
            });
        <?php } ?>

        $(document).ready(function() {
            $('#paymentHistoryTable').DataTable({
                "order": [
                    [1, "desc"]
                ]
            });
        });
    </script>
</body>

</html>