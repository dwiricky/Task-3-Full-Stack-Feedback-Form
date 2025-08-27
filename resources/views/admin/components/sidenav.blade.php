<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{route('home')}}">
            <img src="{{ asset('/assets/img/LOGOFM2.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            {{-- <span class="ms-1 font-weight-bold text-white">Furniture Max</span> --}}
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        {{-- SIDENAV --}}
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('barang.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">table_view</i>
                    </div>
                    <span class="nav-link-text ms-1">Stok Barang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('promo.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">percent</i>
                    </div>
                    <span class="nav-link-text ms-1">Promo</span>
                </a>
            </li>
            @if (Auth::user()->role == 'super-admin')
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Super Admin Area
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('kategori.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">category</i>
                    </div>
                    <span class="nav-link-text ms-1">Kategori</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('transaksi.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Transaksi</span>
                </a>
            </li>
            @endif
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
            {{-- <a class="btn btn-outline-primary mt-4 w-100"
                href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard?ref=sidebarfree"
                type="button">Dokumentasi Template</a> --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn bg-gradient-primary w-100">
                    <i class="material-icons opacity-10">logout</i> Logout</button>
            </form>
        </div>
    </div>
</aside>
