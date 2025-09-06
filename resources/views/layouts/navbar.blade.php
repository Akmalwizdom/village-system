<div class="me-auto pc-mob-drp">
    <ul class="list-unstyled">
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
    </ul>
</div>
<div class="ms-auto">
    <ul class="list-unstyled">
        @if (Auth::check() && Auth::user()->role_id == \App\Models\Role::ROLE_USER)
            {{-- [ NOTIFICATION DROPDOWN START ] --}}
            @php
                $unreadNotifications = Auth::user()->unreadNotifications;
                $notificationCount = $unreadNotifications->count();
            @endphp
            <li class="dropdown pc-h-item">
                <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="ti ti-bell"></i>
                    @if ($notificationCount > 0)
                        <span
                            class="badge bg-danger pc-h-badge">{{ $notificationCount > 99 ? '99+' : $notificationCount }}</span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-notification dropdown-menu-end pc-h-dropdown">
                    <div class="dropdown-header d-flex align-items-center justify-content-between">
                        <h5 class="m-0">Notifikasi</h5>
                        @if ($notificationCount > 0)
                            <span class="badge bg-primary rounded-pill header-badge">{{ $notificationCount }}
                                Baru</span>
                        @endif
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="notification-list-container position-relative"
                        style="max-height: 300px; overflow-y: auto;">
                        @forelse ($unreadNotifications->take(5) as $notification)
                            <div class="list-group-item list-group-item-action notification-item"
                                data-id="{{ $notification->id }}" data-url="{{ url('/complaint') }}"
                                style="cursor: pointer;">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="user-avtar bg-light-success"><i class="ti ti-check"></i></div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">
                                            {{ $notification->data['notification_title'] ?? 'Status Aduan Diperbarui' }}
                                        </h6>
                                        <p class="text-muted text-sm mb-0">
                                            {{ Str::limit($notification->data['message'], 50) }}</p>
                                        <small
                                            class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 px-3 empty-state">
                                <i class="ti ti-bell-off display-5 text-muted mb-2"></i>
                                <p class="text-muted">Tidak ada notifikasi baru</p>
                            </div>
                        @endforelse
                    </div>
                    @if ($notificationCount > 0)
                        <div class="notification-footer">
                            <div class="dropdown-divider"></div>
                            <div class="d-grid px-2 py-2">
                                <button class="btn btn-light-primary" id="markAllReadBtn">
                                    <i class="ti ti-checks me-1"></i> Tandai Semua Dibaca
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="text-center py-2">
                        <a href="{{ route('notifications.index') }}" class="link-primary">Lihat Semua Notifikasi</a>
                    </div>
                </div>
            </li>
            {{-- [ NOTIFICATION DROPDOWN END ] --}}
        @endif

        {{-- [ PROFILE DROPDOWN START ] --}}
        @auth
            <li class="dropdown pc-h-item header-user-profile">
                <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" data-bs-auto-close="outside" aria-expanded="false">
                    <img src="{{ asset('template/dist/assets/images/user/avatar-2.jpg') }}" alt="user-image"
                        class="user-avtar">
                    <span>
                        {{ Auth::user()->name }}
                    </span>
                </a>
                <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                    <div class="dropdown-header">
                        <div class="d-flex mb-1">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('template/dist/assets/images/user/avatar-2.jpg') }}" alt="user-image"
                                    class="user-avtar wid-35">
                            </div>
                            <div class="flex-grow-1 ms-1 d-flex flex-column justify-content-center">
                                <h6 class="mb-1">{{ Auth::user()->name }}</h6>
                                <span>{{ optional(Auth::user()->role)->name }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('profile.index') }}" class="dropdown-item">
                        <i class="ti ti-user"></i>
                        <span>Lihat Profil</span>
                    </a>
                    <a href="{{ route('profile.change-password') }}" class="dropdown-item">
                        <i class="ti ti-key"></i>
                        <span>Ganti Password</span>
                    </a>
                    <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="ti ti-power text-danger"></i>
                        <span>Logout</span>
                    </a>
                </div>
            </li>
        @endauth 
        {{-- [ PROFILE DROPDOWN END ] --}}
    </ul>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationContainer = document.querySelector('.notification-list-container');
            const markAllReadBtn = document.getElementById('markAllReadBtn');
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const markOneAsRead = (item) => {
                const notificationId = item.dataset.id;
                const redirectUrl = item.dataset.url;
                fetch(`/notifications/${notificationId}/read`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (redirectUrl) {
                                window.location.href = redirectUrl;
                            }
                        }
                    })
                    .catch(console.error);
            };
            if (notificationContainer) {
                notificationContainer.addEventListener('click', function(event) {
                    const item = event.target.closest('.notification-item');
                    if (item) {
                        markOneAsRead(item);
                    }
                });
            }
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function() {
                    this.disabled = true;
                    this.innerHTML =
                        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...`;
                    fetch('/notifications/mark-all-read', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const items = document.querySelectorAll('.notification-item');
                                items.forEach((item, index) => {
                                    setTimeout(() => animateAndRemove(item), index * 100);
                                });
                                setTimeout(() => updateCount(items.length, true), items.length * 100 +
                                    400);
                            } else {
                                this.disabled = false;
                                this.innerHTML =
                                '<i class="ti ti-checks me-1"></i> Tandai Semua Dibaca';
                            }
                        })
                        .catch(console.error);
                });
            }
            const animateAndRemove = (element) => {
                element.style.transition = 'all 0.4s ease-out';
                element.style.opacity = '0';
                element.style.transform = 'translateX(20px)';
                setTimeout(() => {
                    element.remove();
                    checkIfEmpty();
                }, 400);
            };
            const updateCount = (amount, isMarkAll = false) => {
                const badge = document.querySelector('.pc-h-badge');
                const headerBadge = document.querySelector('.header-badge');
                if (isMarkAll) {
                    if (badge) badge.remove();
                    if (headerBadge) headerBadge.remove();
                    return;
                }
                if (badge) {
                    let currentCount = parseInt(badge.textContent, 10);
                    let newCount = currentCount - amount;
                    if (newCount <= 0) {
                        badge.remove();
                        if (headerBadge) headerBadge.remove();
                    } else {
                        badge.textContent = newCount;
                        if (headerBadge) headerBadge.textContent = `${newCount} Baru`;
                    }
                }
            };
            const checkIfEmpty = () => {
                const container = document.querySelector('.notification-list-container');
                if (container && container.children.length === 0) {
                    const emptyStateHtml = `
                <div class="text-center py-5 px-3 empty-state">
                    <i class="ti ti-bell-off display-5 text-muted mb-2"></i>
                    <p class="text-muted">Tidak ada notifikasi baru</p>
                </div>`;
                    container.innerHTML = emptyStateHtml;
                    const footer = document.querySelector('.notification-footer');
                    if (footer) footer.remove();
                }
            };
        });
    </script>
@endpush
