<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login | Pencatatan Stok Barang</title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('hope-ui/assets/images/favicon.ico') }}" />
    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="{{ asset('hope-ui/assets/css/core/libs.min.css') }}" />
    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="{{ asset('hope-ui/assets/css/hope-ui.min.css?v=2.0.0') }}" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('hope-ui/assets/css/custom.min.css?v=2.0.0') }}" />
    <!-- Dark Css -->
    <link rel="stylesheet" href="{{ asset('hope-ui/assets/css/dark.min.css') }}" />
    <!-- Customizer Css -->
    <link rel="stylesheet" href="{{ asset('hope-ui/assets/css/customizer.min.css') }}" />
    <!-- RTL Css -->
    <link rel="stylesheet" href="{{ asset('hope-ui/assets/css/rtl.min.css') }}" />
    {{-- override kamu, paling bawah sendiri ✅ --}}
    <link rel="stylesheet" href="{{ asset('hope-ui/assets/css/custom-theme.css') }}" />
</head>

<body class=" " data-bs-spy=" scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->
    <div class="wrapper">
        <section class="login-content">
            <div class="row m-0 align-items-center bg-white vh-100">
                <div class="col-md-6">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card card-transparent shadow-none d-flex justify-content-center mb-0
auth-card">
                                <div class="card-body">
                                    <a href="dashboard.html" class="navbar-brand d-flex align-items-center
mb-3">
                                        <!--Logo start-->
                                        <div class="logo-main">
                                            <div class="logo-normal">

                                                <img src="{{ asset('hope-ui/assets/images/icons/loubishop-logo.svg')}}" class="text-primary icon-30"/>
                                            </div>
                                            <div class="logo-mini">
                                                <img src="{{ asset('hope-ui/assets/images/icons/loubishop-logo.svg')}}"/>
                                            </div>
                                        </div>
                                        <!--Logo End-->
                                        <h4 class="logo-title ms-3">Sistem Inventori Toko LoubiShop</h4>
                                    </a>
                                    <h2 class="mb-2 text-center">Login Admin</h2>
                                    <p class="text-center">Masuk untuk mengelola pencatatan stok barang pada toko LoubiShop.</p>
                                    @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show"
                                        role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bsdismiss="alert"></button>
                                    </div>
                                    @endif
                                    @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show"
                                        role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bsdismiss="alert"></button>
                                    </div>
                                    @endif
                                    @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show"
                                        role="alert">
                                        <strong>Terjadi kesalahan:</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bsdismiss="alert"></button>
                                    </div>
                                    @endif
                                    <form action="{{ route('login.process') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        value="{{ old('email') }}" aria-describedby="email" placeholder="Masukkan email admin" required>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input type="password" name="password" class="form-control" aria-describedby="password" placeholder="Masukkan password" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary px5">Login</button>
                                        </div>
                                        <p class="mt-4 text-center text-muted mb-0">
                                            Sistem Pencatatan Keluar Masuk Barang
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
                    <img src="{{ asset('hope-ui/assets/images/auth/ujicoba.png')}}" class="img-fluid gradientmain animated-scaleX" alt="Ilustrasi Login Pencatatan Stok Barang">
                </div>
            </div>
        </section>
    </div>
    <!-- Library Bundle Script -->
    <script src="{{ asset('hope-ui/assets/js/core/libs.min.js')}}"></script>
    <!-- External Library Bundle Script -->
    <script src="{{ asset('hope-ui/assets/js/core/external.min.js')}}"></script>
    <!-- Widgetchart Script -->
    <script src="{{ asset('hope-ui/assets/js/charts/widgetcharts.js')}}"></script>
    <!-- mapchart Script -->
    <script src="{{ asset('hope-ui/assets/js/charts/vectore-chart.js')}}"></script>
    <script src="{{ asset('hope-ui/assets/js/charts/dashboard.js')}}"></script>
    <!-- fslightbox Script -->
    <script src="{{ asset('hope-ui/assets/js/plugins/fslightbox.js')}}"></script>
    <!-- Settings Script -->
    <script src="{{ asset('hope-ui/assets/js/plugins/setting.js')}}"></script>
    <!-- Slider-tab Script -->
    <script src="{{ asset('hope-ui/assets/js/plugins/slider-tabs.js')}}"></script>
    <!-- Form Wizard Script -->
    <script src="{{ asset('hope-ui/assets/js/plugins/form-wizard.js')}}"></script>
    <!-- App Script -->
    <script src="{{ asset('hope-ui/assets/js/hope-ui.js')}}" defer></script>
</body>

</html>