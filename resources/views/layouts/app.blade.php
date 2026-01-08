<!DOCTYPE html>
<html lang="en">
<head>
  <title>SiDesa</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
  <meta name="author" content="CodedThemes">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" href="{{ asset('template/dist/assets/images/favicon.svg') }}" type="image/x-icon"> <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<link rel="stylesheet" href="{{ asset('template/dist/assets/fonts/tabler-icons.min.css') }}" >
<link rel="stylesheet" href="{{ asset('template/dist/assets/fonts/feather.css') }}" >
<link rel="stylesheet" href="{{ asset('template/dist/assets/fonts/fontawesome.css') }}" >
<link rel="stylesheet" href="{{ asset('template/dist/assets/fonts/material.css') }}" >
<link rel="stylesheet" href="{{ asset('template/dist/assets/css/style.css') }}" id="main-style-link" >
<link rel="stylesheet" href="{{ asset('template/dist/assets/css/style-preset.css') }}">
<!-- SiDesa Custom Theme -->
<link rel="stylesheet" href="{{ asset('css/sidesa-theme.css') }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Force Dark Mode -->
<script>document.documentElement.setAttribute('data-pc-theme', 'dark');</script>
</head>
<body data-pc-preset="preset-sidesa" data-pc-direction="ltr" data-pc-theme="dark">
  <div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
@include('layouts.sidebar')
<header class="pc-header">
  <div class="header-wrapper"> 
    @include('layouts.navbar')
 </div>
</header>
<div class="pc-container">
    <div class="pc-content">
      @include('layouts.header')
      @yield('content')
      </div>
  </div>
  @include('layouts.footer')

  <script src="{{ asset('template/dist/assets/js/plugins/apexcharts.min.js') }}"></script>
  <script src="{{ asset('template/dist/assets/js/pages/dashboard-default.js') }}"></script>
  <script src="{{ asset('template/dist/assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('template/dist/assets/js/plugins/simplebar.min.js') }}"></script>
  <script src="{{ asset('template/dist/assets/js/plugins/bootstrap.min.js') }}"></script>
  <script src="{{ asset('template/dist/assets/js/fonts/custom-font.js') }}"></script>
  <script src="{{ asset('template/dist/assets/js/pcoded.js') }}"></script>
  <script src="{{ asset('template/dist/assets/js/plugins/feather.min.js') }}"></script>

  <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="logoutModalLabel">
            <i class="ti ti-power text-danger me-2"></i>
            Konfirmasi Logout
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <i class="ti ti-alert-circle text-warning" style="font-size: 48px;"></i>
            <h6 class="mt-3">Apakah Anda yakin ingin logout?</h6>
            <p class="text-muted mb-0">Anda akan diarahkan ke halaman login setelah logout.</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="ti ti-x me-1"></i>
            Batal
          </button>
          <form action="/logout" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger">
              <i class="ti ti-power me-1"></i>
              Ya, Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @stack('scripts')
  </body>
</html>