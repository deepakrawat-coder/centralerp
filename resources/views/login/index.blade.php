<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ERP</title>

    <!-- Bootstrap + Your Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>

<body>

<section>
    <div class="container-fluid">
        <div class="row">

            <!-- LEFT IMAGE -->
            <div class="col-xl-7 d-none d-xl-block">
                <img class="bg-img-cover bg-center" src="{{ asset('assets/images/login/2.jpg') }}" alt="login-page">
            </div>

            <!-- RIGHT LOGIN -->
            <div class="col-xl-5 p-0">
                <div class="login-card flex-column">


                    <form method="POST" action="{{ route('login') }}" class="theme-form login-form">
                        
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Login</h3>
                        <p class="text-muted">Welcome back! Please login to continue.</p>
                    </div>

                    {{-- Show login errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger py-2">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    {{-- Session status --}}
                    @session('status')
                        <div class="alert alert-success py-2">
                            {{ $value }}
                        </div>
                    @endsession
                        @csrf

                        <!-- Email -->
                        <div class="form-group">
                            <label>Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i data-feather="mail"></i></span>
                                <input class="form-control"
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required autofocus autocomplete="username">
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i data-feather="lock"></i></span>
                                <input class="form-control"
                                    id="password"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password">
                            </div>
                        </div>

                        <!-- Remember me + Submit -->
                        <div class="form-group d-flex justify-content-between align-items-center">
                            <label class="d-flex align-items-center">
                                <input type="checkbox" name="remember" id="remember_me" class="me-2">
                                <span>Remember me</span>
                            </label>

                            <button type="submit" class="btn btn-primary px-4">
                                Log In
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Scripts -->
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap/bootstrap.min.js') }}"></script>
<script src="https://unpkg.com/feather-icons"></script>
<script>
    feather.replace()
</script>

</body>
</html>
