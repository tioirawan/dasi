<?php
    $sekolah = $db->getSchoolData($data["id_sekolah"], PDO::FETCH_OBJ);

    $cp = explode(".", basename($_SERVER["SCRIPT_FILENAME"]))[0];
?>


<nav class="navbar hide-small fixed-top navbar-expand-sm bg-primary navbar-dark navbar-fixed">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
        </li>
    </ul>
    <a class="navbar-brand mr-xs-0" href="dashboard.php"><img src="../assets/dasi_white.svg" alt="">Dasi</a>
</nav> 

<div class="page-wrapper toggled chiller-theme">
    <a id="show-sidebar" class="btn btn-sm text-white" href="#">
        <i class="fas fa-bars"></i>
    </a>
    <nav id="sidebar" class="sidebar-wrapper">
        <div class="sidebar-content">
            <div class="sidebar-brand" id="close-sidebar">
                <a>Tutup</a>
                <div>
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="sidebar-header">                
                <div class="siswa-info">
                    <span class="siswa-name"><?=ucwords($data["nama"])?></span>
                    <span class="siswa-id"><?=$data["nisn"]?></span>
                    <span class="siswa-role"><?=$sekolah->nama_sekolah?></span>
                </div>
            </div>
            <div class="sidebar-menu">
                    <ul>
                        <li class="header-menu">
                            <span>Saldo</span>
                        </li>
                        <li>
                            <a><?=boldGreen(rupiah($data["saldo"]))?></a>
                        </li>
                        <!--<li class="topup">
                            <div class="bgtopup">
                                <span>Top Up</span>
                            </div>
                        </li>-->
                    </ul>
            </div>
            
            <!-- sidebar-search  -->
            <div class="sidebar-menu">
                <ul>
                    <li class="header-menu">
                        <span>Menu</span>
                    </li>
                    <li>
                        <a href="dashboard.php">
                            <i class="fas fa-tachometer-alt <?= $cp == "dashboard" ? "tab-active" : ""?>"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="scan.php">
                            <i class="fas fa-search <?= $cp == "scan" ? "tab-active" : ""?>"></i>
                            <span>Scan</span>
                        </a>
                    </li>
                    <li>
                        <a href="spp.php">
                            <i class="fas fa-book <?= $cp == "spp" ? "tab-active" : ""?>"></i>
                            <span>SPP</span>
                        </a>
                    </li>
                    <li>
                        <a href="kirim.php">
                            <i class="fas fa-money-check-alt <?= $cp == "kirim" ? "tab-active" : ""?>"></i>
                            <span>Transfer</span>
                        </a>
                    </li>
                    <li>
                        <a href="donasi.php">
                            <i class="fas fa-hand-holding-usd <?= $cp == "donasi" ? "tab-active" : ""?>"></i>
                            <span>Donasi</span>
                        </a>
                    </li>
                    <li>
                        <a href="history.php">
                            <i class="fa fa-history <?= $cp == "history" ? "tab-active" : ""?>"></i>
                            <span>History</span>
                        </a>
                    </li>                    
                </ul>
            </div>
            <!-- sidebar-menu  -->
        </div>
        <!-- sidebar-content  -->
        <div class="sidebar-footer">
            <a href="pengaturan.php">
                <i class="fa fa-cog"></i>                
            </a>
            <a href="../actions/logout.php">
                <i class="fa fa-power-off"></i>
            </a>
        </div>
    </nav>
    <!-- sidebar-wrapper  -->
    <main class="page-content fadeInRight"> 
    <div class="container-fluid" id="mainbody">
