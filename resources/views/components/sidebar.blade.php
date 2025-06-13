@auth
<!-- Toggle Button (di luar sidebar, hanya tampil di mobile) -->
<button class="btn btn-primary d-md-none mb-2" id="sidebarToggle"
    style="position:fixed;top:15px;left:15px;z-index:2000;">
    <i class="fas fa-bars"></i>
</button>

<div class="main-sidebar sidebar-style-2" id="main-sidebar">
    <aside id="sidebar-wrapper">
        <div style="margin-top:16px;">
            <div class="sidebar-brand">
                <div class="card-header text-center d-flex justify-content-center">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="img-fluid" style="width: 150px;">
                    </div>
                </div>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <div class="card-header text-center d-flex justify-content-center">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('img/tutwuri.png') }}" alt="Logo" class="img-fluid mt-2" style="width: 40px;">
                    </div>
                </div>
            </div>
        </div>
        <!-- MENU TETAP DI DALAM SIDEBAR -->
        <ul class="sidebar-menu">
            @if (Auth::user()->role == 'superadmin')
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/dashboard/admin') }}">
                    <i class="fas fa-fire"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">USER</li>
            <li class="{{ Request::is('hakakses') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('hakakses') }}"><i class="fas fa-user"></i> <span>Pengguna</span></a>
            </li>
            <li class="menu-header">PAGES</li>
            <li class="{{ Request::is('perguruan_tinggi') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('perguruan_tinggi') }}"><i class="fas fa-university"></i>
                    <span>Perguruan Tinggi</span></a>
            </li>
            <li class="{{ Request::is('klaster_wilayah') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('klaster_wilayah') }}"><i class="fas fa-university"></i> <span>Klaster Wilayah</span></a>
            </li>
            <li class="{{ Request::is('periode_penetapan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('periode_penetapan') }}"><i class="fas fa-university"></i>
                    <span>Periode Penetapan</span></a>
            </li>
            <li class="menu-header">MANAGEMENT</li>
            <li class="{{ Request::is('pengajuan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('pengajuan') }}"><i class="fas fa-list"></i> <span>Daftar Ajuan Penetapan</span></a>
            </li>
            <li class="{{ Request::is('admin/pencairan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/pencairan') }}"><i class="fas fa-list"></i> <span>Daftar Ajuan Pencairan</span></a>
            </li>
            <li class="{{ Request::is('admin/mahasiswa-finalisasi') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/mahasiswa-finalisasi') }}"><i class="fas fa-list"></i> <span>Mahasiswa Ditetapkan</span></a>
            </li>
            <li class="{{ Request::is('admin/laporan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/laporan') }}"><i class="fas fa-list"></i>
                    <span>History</span></a>
            </li>
            <li class="menu-header">Others</li>
            <li class="{{ Request::is('admin/mahasiswa-pddikti') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin/mahasiswa-pddikti') }}"><i class="fas fa-list"></i>
                    <span>Mahasiswa PDDIKTI</span></a>
            </li>
            @endif

            @if (Auth::user()->role == 'operator')
            <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/dashboard/operator') }}">
                    <i class="fas fa-fire"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="menu-header">Pages</li>
            <li class="{{ Request::is('program_studi') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('program_studi') }}"><i class="fas fa-university"></i> <span>Program Studi</span></a>
            </li>
            <li class="{{ Request::is('operator/mahasiswa-ditetapkan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/operator/mahasiswa-ditetapkan') }}"><i class="fas fa-university"></i>
                    <span>Mahasiswa Ditetapkan</span></a>
            </li>
            <li class="menu-header">MANAGEMENT</li>
            <li class="{{ Request::is('pengajuan_penetapan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('pengajuan_penetapan') }}"><i class="fas fa-list"></i> <span>Penetapan Awal</span></a>
            </li>
            <li class="{{ Request::is('pencairan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/pencairan') }}"><i class="fas fa-list"></i>
                    <span>Pengajuan Pencairan</span></a>
            </li>
            <li class="{{ Request::is('laporan/history') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/laporan/history') }}"><i class="fas fa-list"></i>
                    <span>History</span></a>
            </li>
            @endif
        </ul>
        <div style="height:60px;"></div>
    </aside>
</div>

<!-- Overlay for mobile -->
<div id="sidebar-overlay" style="display:none;position:fixed;z-index:1049;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.1);"></div>

<style>
#sidebar-wrapper {
    height: auto;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    background: #fff;
    position: relative;
}
.sidebar-menu{
    font-size: 13px;
    min-height: 0;
    margin-bottom: 0;
    padding-bottom: 6px;
}

.sidebar-menu li a {
    padding-top: 6px;
    padding-bottom: 6px;
}
.sidebar-menu .menu-header {
    font-size: 13px;
    color: #a0a4a8;
    letter-spacing: 2px;
    font-weight: 600;
}

.sidebar-menu .menu-header:first-child {
    margin-top: 0; /* agar section pertama tidak terlalu jauh dari atas */
}

.sidebar-brand,
.sidebar-brand-sm {
    flex-shrink: 0;
}
#sidebar-wrapper > div[style*="padding: 1rem"] {
    flex-shrink: 0;
    background: #fff;
    border-top: 1px solid #eee;
}
@media (max-width: 768px) {
    #main-sidebar {
        position: fixed;
        left: -260px;
        top: 0;
        width: 260px;
        height: 100vh;
        z-index: 1050;
        transition: left 0.3s;
        background: #fff;
        box-shadow: 2px 0 8px rgba(0,0,0,0.1);
    }
    #main-sidebar.active {
        left: 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var sidebar = document.getElementById('main-sidebar');
    var toggleBtn = document.getElementById('sidebarToggle');
    var overlay = document.getElementById('sidebar-overlay');

    toggleBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        sidebar.classList.toggle('active');
        document.body.classList.toggle('sidebar-open');
        if(window.innerWidth <= 768){
            overlay.style.display = sidebar.classList.contains('active') ? 'block' : 'none';
        }
    });

    overlay.addEventListener('click', function() {
        sidebar.classList.remove('active');
        document.body.classList.remove('sidebar-open');
        overlay.style.display = 'none';
    });

    document.addEventListener('click', function(e) {
        if(window.innerWidth <= 768){
            if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target) && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
                document.body.classList.remove('sidebar-open');
                overlay.style.display = 'none';
            }
        }
    });
    sidebar.addEventListener('click', function(e) {
        e.stopPropagation();
    });
});
</script>
@endauth