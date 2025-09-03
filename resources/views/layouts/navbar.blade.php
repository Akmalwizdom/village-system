<div class="me-auto pc-mob-drp">
    <ul class="list-unstyled">
        <!-- ======= Menu collapse Icon ===== -->
        <li class="pc-h-item pc-sidebar-collapse">
            <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                <i class="ti ti-menu-2"></i>
            </a>
        </li>
        <li class="pc-h-item pc-sidebar-popup">
            <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                <i class="ti ti-menu-2"></i>
            </a>
        </li>
        <li class="dropdown pc-h-item d-inline-flex d-md-none">
            <a class="pc-head-link dropdown-toggle arrow-none m-0" data-bs-toggle="dropdown" href="#"
                role="button" aria-haspopup="false" aria-expanded="false">
                <i class="ti ti-search"></i>
            </a>
            <div class="dropdown-menu pc-h-dropdown drp-search">
                <form class="px-3">
                    <div class="form-group mb-0 d-flex align-items-center">
                        <i data-feather="search"></i>
                        <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . .">
                    </div>
                </form>
            </div>
        </li>
        <li class="pc-h-item d-none d-md-inline-flex">
            <form class="header-search">
                <i data-feather="search" class="icon-search"></i>
                <input type="search" class="form-control" placeholder="Search here. . .">
            </form>
        </li>
    </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
    <ul class="list-unstyled">
        {{-- [ NOTIFICATION DROPDOWN START ] --}}
        <li class="dropdown pc-h-item">
            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                role="button" aria-haspopup="false" aria-expanded="false">
                <i class="ti ti-bell"></i>
                {{-- Tampilkan badge jika ada notifikasi yang belum dibaca --}}
                @if (isset($notificationCount) && $notificationCount > 0)
                    <span class="badge bg-danger pc-h-badge">{{ $notificationCount }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                <div class="dropdown-header d-flex align-items-center justify-content-between">
                    <h5 class="m-0">Notifications</h5>
                    {{-- Jika perlu, tambahkan link untuk menandai semua sudah dibaca --}}
                    {{-- <a href="#!" class="pc-head-link bg-transparent">Mark as read</a> --}}
                </div>
                <div class="dropdown-divider"></div>
                <div class="dropdown-header px-0 text-wrap header-notification-scroll position-relative"
                    style="max-height: calc(100vh - 215px)">
                    <div class="list-group list-group-flush w-100">

                        {{-- Loop melalui notifikasi dan tampilkan --}}
                        @forelse ($notifications as $notification)
                            <a class="list-group-item list-group-item-action" href="{{ url('/complaint') }}">
                                {{-- Arahkan ke halaman aduan --}}
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="user-avtar bg-light-success"><i class="ti ti-check"></i></div>
                                    </div>
                                    <div class="flex-grow-1 ms-1">
                                        <span
                                            class="float-end text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                                        <p class="text-body mb-1"><b>{{ $notification->data['notification_title'] ?? 'Status Aduan Diperbarui' }}</b></p>
                                        </p>
                                        <span class="text-muted">{{ $notification->data['message'] }}</span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            {{-- Tampilkan pesan jika tidak ada notifikasi --}}
                            <div class="list-group-item">
                                <div class="text-center">
                                    <p class="text-muted my-2">Tidak ada notifikasi baru.</p>
                                </div>
                            </div>
                        @endforelse

                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="text-center py-2">
                    <a href="#!" class="link-primary">View all</a> {{-- Ganti #! dengan link ke halaman semua notifikasi --}}
                </div>
            </div>
        </li>
        {{-- [ NOTIFICATION DROPDOWN END ] --}}

        <li class="dropdown pc-h-item header-user-profile">
            <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                <img src="{{ asset('template/dist/assets/images/user/avatar-2.jpg') }}" alt="user-image"
                    class="user-avtar">
                <span>@auth
                        {{ Auth::user()->name }}
                    @else
                        Guest
                    @endauth
                </span>
            </a>
            <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                <div class="dropdown-header">
                    <div class="d-flex mb-1">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('template/dist/assets/images/user/avatar-2.jpg') }}" alt="user-image"
                                class="user-avtar wid-35">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Stebin Ben</h6>
                            <span>UI/UX Designer</span>
                        </div>
                        <a href="#!" class="pc-head-link bg-transparent"><i
                                class="ti ti-power text-danger"></i></a>
                    </div>
                </div>
                <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="drp-t1" data-bs-toggle="tab" data-bs-target="#drp-tab-1"
                            type="button" role="tab" aria-controls="drp-tab-1" aria-selected="true"><i
                                class="ti ti-user"></i> Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="drp-t2" data-bs-toggle="tab" data-bs-target="#drp-tab-2"
                            type="button" role="tab" aria-controls="drp-tab-2" aria-selected="false"><i
                                class="ti ti-settings"></i> Setting</button>
                    </li>
                </ul>
                <div class="tab-content" id="mysrpTabContent">
                    <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel" aria-labelledby="drp-t1"
                        tabindex="0">
                        <a href="/profile" class="dropdown-item">
                            <i class="ti ti-user"></i>
                            <span>View Profile</span>
                        </a>
                        <a href="/change-password" class="dropdown-item">
                            <i class="ti ti-key"></i>
                            <span>Change Password</span>
                        </a>
                        <a href="#" class="dropdown-item" data-bs-toggle="modal"
                            data-bs-target="#logoutModal">
                            <i class="ti ti-power"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                    <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2"
                        tabindex="0">
                        <a href="#!" class="dropdown-item">
                            <i class="ti ti-help"></i>
                            <span>Support</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="ti ti-user"></i>
                            <span>Account Settings</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="ti ti-lock"></i>
                            <span>Privacy Center</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="ti ti-messages"></i>
                            <span>Feedback</span>
                        </a>
                        <a href="#!" class="dropdown-item">
                            <i class="ti ti-list"></i>
                            <span>History</span>
                        </a>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>
