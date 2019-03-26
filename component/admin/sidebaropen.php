<nav class="navbar fixed-top navbar-expand-sm bg-primary navbar-dark navbar-fixed">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
        </li>
    </ul>
    <a class="navbar-brand" href="#"><img src="../assets/dasi_white.svg" alt="">Dasi</a>
</nav> 

<div class="page-wrapper chiller-theme">
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
                <div class="user-info">
                    <span class="user-name"><?=ucwords($data["nama"])?></span>
                </div>
            </div>
            
            <!-- sidebar-search  -->
            <div class="sidebar-menu">
                <ul>
                    <li class="header-menu">
                        <span>Menu</span>
                    </li>
                    <li>
                        <a href="dashboard.php">
                            <i class="fas fa-book"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="siswa.php">
                            <i class="fas fa-book"></i>
                            <span>Siswa</span>
                        </a>
                    </li>

                    <li>
                        <a href="toko.php">
                            <i class="fas fa-store"></i>
                            <span>Toko</span>
                        </a>
                    </li>

                    <li>
                        <a href="donasi.php">
                            <i class="fas fa-book"></i>
                            <span>Donasi</span>
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
    <main class="page-content"> 
    <div class="container-fluid" id="mainbody">