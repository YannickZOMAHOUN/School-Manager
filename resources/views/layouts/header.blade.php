
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex  align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <div class="d-flex align-items-center  pe-md-3">
          <img src="{{asset("images/logo.png")}}" alt="" class="logo-header">
      </div>
      <i class="bi bi-list toggle-sidebar-btn text-color-avt"></i>
    </div><!-- End Logo -->


    {{-- application name  --}}

    <div class="mx-auto text-center">
        <h3 class="fs-16 text-uppercase font-medium text-color-avt mb-0">GESTION DES BULLETINS</h3>
    </div>
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
          <li class="nav-item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" id="dropdownMenuLink">
              <span class="pe-1 pe-lg-0"><i class="fas fa-user text-color-avt"></i></span>
              <span class="d-none d-md-block dropdown-toggle ps-2 text-color-avt font-light">{{ auth()->user()->surname.' '.auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile" aria-labelledby="dropdownMenuLink">
              <li class="dropdown-header">
                <h6>{{ auth()->user()->surname.' '.auth()->user()->name }}</h6>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center" style="cursor: pointer" href="#">
                  <i class="fas fa-user"></i>
                  <span>&nbsp; Mon Profil</span>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="fas fa-sign-out-alt"></i>&nbsp; Déconnexion
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                  {{ csrf_field() }}
                </form>
              </li>
            </ul><!-- End Profile Dropdown Items -->
          </li><!-- End Profile Nav -->
        </ul>
      </nav><!-- End Icons Navigation -->
  </header><!-- End Header -->
