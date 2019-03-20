<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>
    <title>Dashboard</title>
</head>

<body>
    <?php include "../process/getUserData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <h1>Scan</h1>

    <video id="preview" style="border: 2px solid black"></video>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script type="text/javascript">
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview'), scanPeriod: 5 
        });
        scanner.addListener('scan', function(content) {
            alert(content);
        });
        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[1]);
            } else {
                console.error('No cameras found.');
            }
        }).catch(function(e) {
            console.error(e);
        });

    </script>
</body>

</html> 