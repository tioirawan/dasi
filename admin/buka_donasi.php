<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Buka Donasi</title>
</head>

<body>
    <?php include "../process/getAdminLoginData.php" ?>
    <?php include "../component/admin/sidebaropen.php" ?>

    <h1>Buka Donasi Baru</h1>

    <form action="../actions/donasi_baru.php" method="post">
        <div class="row">
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" class="form-control" name="judul" id="judul" placeholder="Tujuan Donasi" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="10"></textarea>
                </div>

                <div class="form-group">
                    <label for="target">Target</label>
                    <input type="number" class="form-control" name="target" id="target" placeholder="Target Donasi" required>
                </div>
                
                <input type="hidden" name="idposter" value="<?=$data["id"]?>">
            </div>
        </div>

        <input type="submit" class="btn btn-primary" value="Buka Donasi">
    </form>

    </div>



    <?php include "../component/admin/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>
</body>

</html> 