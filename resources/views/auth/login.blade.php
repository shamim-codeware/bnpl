<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buy Now Pay Later - Rangs</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/plugin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/variables.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

    {{-- <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon.png') }}"> --}}
</head>

<body>
    <main style="background: #e6e6e6" class="main-content d-flex align-items-center justify-content-center">
        <div class="admin d-flex align-items-center">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-6 d-flex align-items-center justify-content-center position-relative">
                        <img class="img-fluid login_img" src="{{ asset('assets/img/login_bg.png') }}" alt="img">
                        <img class="position-absolute end-0 login_logo" src="{{ asset('assets/img/rangs-logo-1.png') }}" alt="rangs-logo">
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-md-8">
                                <div class="edit-profile">
                                    <div class="col-lg-12">
                                        <div class="text-center">
                                            <h1 class="fs-3" style="color: #3a7148">Buy Now Pay Later - Rangs</h1>
                                        </div>
                                    </div>
                                    <div class="edit-profile__logos">
                                        <img class="dark" src="{{ asset('assets/img/logo-dark.png') }}"
                                            alt="">
                                        <img class="light" src="{{ asset('assets/img/logo-white.png') }}"
                                            alt="">
                                    </div>
                                    <div class="card border-0">
                                        <div class="card-header p-2">
                                            <div class="edit-profile__title">
                                                <h6>Sign in</h6>
                                            </div>
                                        </div>
                                        <div class="card-body p-4">
                                            <form action="{{ route('authenticate') }}" method="POST">
                                                @csrf
                                                <div class="edit-profile__body">
                                                    <div class="form-group mb-20">
                                                        <label for="email">Mobile Number* </label>
                                                        <input type="number" class="form-control" id="email"
                                                            name="phone" required placeholder="Mobile Number">
                                                        @if ($errors->has('phone'))
                                                            <p class="text-danger">{{ $errors->first('phone') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="form-group mb-15">
                                                        <label for="password-field">Password*</label>
                                                        <div class="position-relative">
                                                            <input id="password-field" required type="password"
                                                                class="form-control" name="password"
                                                                placeholder="Password">
                                                            <span toggle="#password-field"
                                                                class="uil uil-eye-slash text-lighten fs-15 field-icon toggle-password2"></span>
                                                        </div>
                                                        @if ($errors->has('password'))
                                                            <p class="text-danger">{{ $errors->first('password') }}</p>
                                                        @endif
                                                    </div>
                                                    {{-- <div class="admin-condition">
                                                <div class="checkbox-theme-default custom-checkbox ">
                                                    <input class="checkbox" type="checkbox" id="check-1">
                                                    <label for="check-1">
                                                        <span class="checkbox-text">Keep me logged in</span>
                                                    </label>
                                                </div>
                                            </div> --}}
                                                    <div
                                                        class="admin__button-group button-group d-flex pt-1 justify-content-md-start justify-content-center">
                                                        <button
                                                            class="btn btn-primary btn-default w-100 fw-bold btn-squared text-capitalize lh-normal px-50 signIn-createBtn ">
                                                            sign in
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div id="overlayer">
        <div class="loader-overlay">
            <div class="">
                {{-- <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span> --}}
                <img id="pulse" src="{{ asset('assets/img/rangs-logo-1.png') }}" alt="rangs-logo">
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/plugins.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>
        $(document).ready(function() {
            toastr.options.timeOut = 10000;
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif (Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif

        });
    </script>
</body>

</html>
