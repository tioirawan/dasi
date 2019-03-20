<?php
include "../phpqrcode/qrlib.php";

QRCode::png("test", "../qrcodes/test.png", "L", 5, 5);
?>
<img src="../qrcodes/test.png" alt="" srcset="">
