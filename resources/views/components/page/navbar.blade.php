<link rel="stylesheet" href="{{asset('assets/css/components/navbar.css')}}">
<!--Main Navigation-->
<header class="sticky-top border border-bottom-2">
  <!-- Jumbotron -->
  <div class="p-3 text-center bg-white border-bottom">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-between">
        <!-- Left elements -->
        <div class="col-5 justify-content-start align-items-center d-flex">
          <a href="/" class="ms-md-2">
            <img src="{{asset('assets/img/LOGOFM2.png')}}" height="35" />
          </a>
        </div>
        <!-- Left elements -->

        <!-- Center elements -->
        <div class="col-2 d-none d-lg-block">

        </div>
        <!-- Center elements -->

        <!-- Right elements -->
        <div class="col-5 d-flex justify-content-end gap-4 align-items-center">
          <form method="GET" action="{{ route('list-produk') }}" class="d-none d-md-flex input-group w-auto mb-3 mb-md-0">
            <input autocomplete="off" type="search" class="form-control rounded" name="search" placeholder="Cari Barang [ Ctrl + / ]" />
            <span class="input-group-text border-0 d-none d-lg-flex"><i class="bi bi-search"></i></span>
            @csrf
          </form>
          @if (Auth::check())
            <div class="d-none d-md-flex gap-2 flex-column flex-lg-row align-items-center">
              <i class="bi bi-person-fill d-none d-lg-block"></i>
              <div class="text-uppercase">{{Auth::user()->nama}}</div>
            </div>
          @else
            <div class="d-none d-md-flex gap-2 p-2 btn btn-outline-coklat-gelap">
              <i class="bi bi-box-arrow-in-right"></i>
              <a href="{{route('login')}}" class="text-decoration-none text-uppercase">Login</a>
            </div>
          @endif
            <div class="d-flex d-md-none">
              <a id="ganti-icon-a">
                <i class="bi bi-list fs-2 text-dark" id="icon-a"></i>
              </a>
            </div>
        </div>
        <!-- Right elements -->
      </div>
    </div>
  </div>
  <!-- Jumbotron -->

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white d-none d-md-block" id="toggle-nav">
    <!-- Container wrapper -->
    <div class="container-fluid flex-column flex-lg-row justify-content-center align-items-end align-items-lg-center w-full justify-content-lg-between">
      <!-- Left elements -->
      <div class="d-grid d-md-block col-12 col-lg-6 col-lg-8 mx-auto mx-lg-0 gap-2 gap-lg-0 align-items-center my-lg-0">

        <a class="btn {{ Request::routeIs('home') ? 'btn-coklat-gelap' : 'btn-outline-coklat-gelap'}} fw-bold text-uppercase me-1" href="{{route('home')}}">
          <i class="bi bi-house me-2 d-none d-sm-inline-block"></i>Home
        </a>
        <a class="btn {{ Request::routeIs('list-produk') ? 'btn-coklat-gelap' : 'btn-outline-coklat-gelap'}} fw-bold text-uppercase me-1" href="{{route('list-produk')}}">
          <i class="bi bi-box2 me-2 d-none d-sm-inline-block"></i>Produk
        </a>
        <a class="btn {{ Request::routeIs('list-promo') ? 'btn-coklat-gelap' : 'btn-outline-coklat-gelap'}} fw-bold text-uppercase me-1" href="{{route('list-promo')}}">
          <i class="bi bi-percent me-2 d-none d-sm-inline-block"></i>Promo
        </a>
        <a class="btn {{ Request::routeIs('about-us') ? 'btn-coklat-gelap' : 'btn-outline-coklat-gelap'}} fw-bold text-uppercase me-1" href="{{route('about-us')}}">
          <i class="bi bi-info-circle-fill me-2 d-none d-sm-inline-block"></i>Tentang
        </a>
        <a class="btn {{ Request::routeIs('faq') ? 'btn-coklat-gelap' : 'btn-outline-coklat-gelap'}} fw-bold text-uppercase me-1" href="{{route('faq')}}">
          <i class="bi bi-question-circle-fill me-2 d-none d-sm-inline-block"></i>FAQ
        </a>

      </div>
      <!-- Left elements -->
      <div class="d-flex d-md-none my-2 text-uppercase">
        @if (Auth::check())
          <i class="bi bi-person-fill me-2"></i>{{Auth::user()->nama}}
        @endif
      </div>
      <!-- Right elements -->
      @if(Auth::check())
        <div class="d-flex gap-2 me-1 mt-0 mt-md-2 mt-lg-0">
          @if(Auth::user()->role == 'admin' || Auth::user()->role == 'super-admin')
            <a class="btn btn-coklat-gelap d-flex align-items-center" href="{{route('dashboard')}}">
              <i class="bi bi-grid me-1"></i>Dashboard
            </a>
          @else
            <a class="btn btn-coklat-gelap d-flex align-items-center" href="{{route('data-pribadi')}}">
              <i class="bi bi-clipboard me-1"></i>Data
            </a>
            <a class="btn btn-coklat-gelap d-flex align-items-center" href="{{route('cart')}}">
              <i class="bi bi-cart me-1"></i>Keranjang
            </a>
            <a class="btn btn-coklat-gelap d-flex align-items-center" href="{{route('order-status')}}">
              <i class="bi bi-cart me-1"></i>Pesanan
            </a>
          @endif
          <form action="{{route('logout')}}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-danger d-flex align-items-center">
              <i class="bi bi-box-arrow-left me-2 fs-5"></i>Keluar
            </button>
          </form>
        </div>
      @else
        <div class="me-1">
          Silahkan <a href="{{route('login')}}">Login</a> Terlebih Dahulu
        </div>
      @endif
      <!-- Right elements -->
    </div>
    <!-- Container wrapper -->
  </nav>
  <!-- Navbar -->
</header>
<script>
  document.addEventListener('keydown', function(event) {
    if (event.ctrlKey && event.key === '/') {
      event.preventDefault();
      document.querySelector('input[type="search"]').focus();
    }
  });
  document.getElementById('ganti-icon-a').addEventListener('click', () => {
    document.getElementById('icon-a').classList.toggle('bi-list');
    document.getElementById('icon-a').classList.toggle('bi-x');

    document.getElementById('toggle-nav').classList.toggle('d-none');
    document.getElementById('toggle-nav').classList.toggle('d-block');
  });
    document.querySelector('input[name="search"]').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            this.form.submit();
        }
    });
</script>
<!--Main Navigation-->