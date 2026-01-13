<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="../dashboard/index.html" class="b-brand text-primary">
                <img src="{{ asset('template/dist/assets/images/logo-dark.svg') }}" class="img-fluid logo-lg"
                    alt="logo">
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
                            <span class="pc-micon"><i class="ti ti-users"></i></span>
                            <span class="pc-mtext">Penduduk</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="/account-request" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-user-check"></i></span>
                            <span class="pc-mtext">Permintaan Akun</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="/account-list" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-list-check"></i></span>
                            <span class="pc-mtext">Daftar Akun</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="/complaint" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-message-report"></i></span>
                            <span class="pc-mtext">Aduan Warga</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="/letter" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-file-text"></i></span>
                            <span class="pc-mtext">Surat</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="/finance" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-report-money"></i></span>
                            <span class="pc-mtext">Keuangan</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="/event" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
                            <span class="pc-mtext">Agenda</span>
                        </a>
                    </li>
                @else
                    <li class="pc-item">
                        <a href="/complaint" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-message-report"></i></span>
                            <span class="pc-mtext">Pengaduan</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="/letter" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-file-text"></i></span>
                            <span class="pc-mtext">Surat</span>
                        </a>
                    </li>

                    <li class="pc-item">
                        <a href="/event" class="pc-link">
                            <span class="pc-micon"><i class="ti ti-calendar-event"></i></span>
                            <span class="pc-mtext">Agenda</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
