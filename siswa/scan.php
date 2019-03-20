<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../component/helmet.php" ?>

    <style>
        #preview {
            min-width: 30vw;
            min-height: 30vw;
            border: 1px solid black
        }
    </style>

    <title>Dashboard</title>
</head>

<body>
    <?php include "../process/getUserData.php" ?>
    <?php include "../component/siswa/sidebaropen.php" ?>

    <h1>Scan</h1>
    
    <div id="container text-center">
        <video id="preview"></video>
        <p id="result"></p>
    </div>

    <?php include "../component/siswa/sidebarclose.php" ?>
    <?php include "../component/scripts.php" ?>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script type="text/javascript">
        let scanner = new Instascan.Scanner({
            video: document.getElementById('preview'),
            scanPeriod: 5,
            mirror: false
        });
        scanner.addListener('scan', function(content) {
            document.getElementById("result").innerHTML = content;
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