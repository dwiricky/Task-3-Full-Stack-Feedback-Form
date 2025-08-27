<nav class="navbar navbar-main navbar-expand-lg px-0 py-4 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3 w-100">
        <nav class="d-flex justify-content-between align-items-center w-100" aria-label="breadcrumb">
            <h4 class="font-weight-bolder mb-0">FURNITURE MAX DASHBOARD</h4>
            <a class="block d-xl-none" id="showsidenav"><i class="fa fa-bars"></i></a>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                {{-- <div class="input-group input-group-outline">
                    <label class="form-label">Type here...</label>
                    <input type="text" class="form-control">
                </div> --}}
            </div>
            <ul class="navbar-nav justify-content-end">
                {{-- <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li> --}}
                {{-- <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li> --}}
                <li class="nav-item d-flex align-items-center">
                    <a class="nav-link text-body font-weight-bold px-0 d-flex align-items-center gap-2">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none text-uppercase">
                            @if (Auth::check())
                                {{Auth::user()->nama}}
                            @endif
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>