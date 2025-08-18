<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
      <a href="../dashboard/index.html" class="b-brand text-primary">
        <img src="{{ asset('template/dist/assets/images/logo-dark.svg') }}" class="img-fluid logo-lg" alt="logo">
      </a>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item">
          <a href="/dashboard" class="pc-link">
            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>

        <li class="pc-item pc-caption">
            <label>Manajemen Data</label>
            <i class="ti ti-dashboard"></i>
        </li>        

        @if (Auth::check() && Auth::user()->role_id == 1)
          <li class="pc-item">
            <a href="/resident" class="pc-link">
              <span class="pc-micon"><i class="ti ti-typography"></i></span>
              <span class="pc-mtext">Penduduk</span>
            </a>
          </li>

          <li class="pc-item">
            <a href="/account-request" class="pc-link">
              <span class="pc-micon"><i class="ti ti-typography"></i></span>
              <span class="pc-mtext">Permintaan Akun</span>
            </a>
          </li>
        @endif
        
        <li class="pc-item">
          <a href="/account-list" class="pc-link">
            <span class="pc-micon"><i class="ti ti-typography"></i></span>
            <span class="pc-mtext">Daftar Akun</span>
          </a>
      </ul>
    </div>
  </div>
</nav>