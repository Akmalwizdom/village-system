<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sign up | SiDesa</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
  <meta name="author" content="CodedThemes">

  <link rel="icon" href="{{ asset('template/dist/assets/images/favicon.svg') }}" type="image/x-icon"> <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
  <link rel="stylesheet" href="{{ asset('template/dist/assets/fonts/tabler-icons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('template/dist/assets/fonts/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('template/dist/assets/fonts/fontawesome.css') }}">
  <link rel="stylesheet" href="{{ asset('template/dist/assets/fonts/material.css') }}">
  <link rel="stylesheet" href="{{ asset('template/dist/assets/css/style.css') }}" id="main-style-link">
  <link rel="stylesheet" href="{{ asset('template/dist/assets/css/style-preset.css') }}">

</head>
<body>
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <div class="auth-main">
    <div class="auth-wrapper v3">
      <div class="auth-form">
        <div class="auth-header">
          <a href="#"><img src="{{ asset('template/dist/assets/images/logo-dark.svg') }}" alt="img"></a>
        </div>
        <div class="card my-5">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-end mb-4">
              <h3 class="mb-0"><b>Sign up</b></h3>
              <a href="/" class="link-primary">Already have an account?</a>
            </div>
            
            <form action="/register" method="post">
              @csrf
              <div class="form-group mb-3">
                <label class="form-label">Full Name<span class="text-danger"> *</span></label>
                <input type="text" name="name" class="form-control" id="inputName" placeholder="Full Name" required>
              </div>
              <div class="form-group mb-3">
                <label class="form-label">Email Address<span class="text-danger"> *</span></label>
                <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email Address" required>
              </div>
              <div class="form-group mb-3">
                <label class="form-label">Password<span class="text-danger"> *</span></label>
                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" required>
              </div>
              <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary">Create Account</button>
              </div>
            </form>
            <div class="saprator mt-3">
              <span>Sign up with</span>
            </div>
            <div class="row">
              <div class="col-4">
                <div class="d-grid">
                  <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                    <img src="{{ asset('template/dist/assets/images/authentication/google.svg') }}" alt="img"> <span class="d-none d-sm-inline-block"> Google</span>
                  </button>
                </div>
              </div>
              <div class="col-4">
                <div class="d-grid">
                  <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                    <img src="{{ asset('template/dist/assets/images/authentication/twitter.svg') }}" alt="img"> <span class="d-none d-sm-inline-block"> Twitter</span>
                  </button>
                </div>
              </div>
              <div class="col-4">
                <div class="d-grid">
                  <button type="button" class="btn mt-2 btn-light-primary bg-light text-muted">
                    <img src="{{ asset('template/dist/assets/images/authentication/facebook.svg') }}" alt="img"> <span class="d-none d-sm-inline-block"> Facebook</span>
                  </button>
                </div>
              </div>
            </div>
            
          </div>
        </div>
        <div class="auth-footer row">
          <div class="col my-1">
              <p class="m-0">Copyright © <a href="#">Codedthemes</a></p>
            </div>
            <div class="col-auto my-1">
              <ul class="list-inline footer-link mb-0">
                <li class="list-inline-item"><a href="#">Home</a></li>
                <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="#">Contact us</a></li>
              </ul>
            </div>
          </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('template/dist/assets/js/plugins/popper.min.js') }}"></script>
  <script src="{{ asset('template/dist/assets/js/plugins/simplebar.min.js') }}"></script>
  <script src="{{ asset('template/dist/assets/js/plugins/bootstrap.min.js') }}"></script>
  <script src="{{ asset('template/dist/assets/js/fonts/custom-font.js') }}"></script>
  <script src="{{ asset('template/dist/assets/js/pcoded.js') }}"></script>
  <script src="{{ asset('template/dist/assets/js/plugins/feather.min.js') }}"></script>

  {{-- Kode untuk customizer tema yang tidak relevan dihapus agar file lebih bersih --}}
    
</body>
</html>