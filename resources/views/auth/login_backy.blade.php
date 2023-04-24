<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ config('app.name', 'Peace Factory') }}: Login</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<script>
    const BASE_URL = '{{ asset('') }}';
</script>
<body class="account-page">

<div class="main-wrapper">
    <div class="account-content">
        <div class="login-wrapper">
            <div class="login-content">
                <div class="login-userset">
                    <div class="login-logo logo-normal">
                        <img src="{{ asset('img/logo.png') }}" alt="img">
                    </div>
                    <a href="{{ asset('') }}" class="login-logo logo-white">
                        <img src="{{ asset('img/logo-white.png') }}" alt="">
                    </a>
                    <form class="sign-in-form" method="post" role="form" action="{{ route('login_process') }}">
                        @csrf
                        <div class="login-userheading">
                            <h3>Sign In</h3>
                            <h4>Please login to your account</h4>
                        </div>
                        @if(session()->has('message'))
                            <span class="text-danger text-center d-block">{{ session()->get('message') }}</span>
                        @endif
                        <div class="form-login">
                            <label>Username</label>
                            <div class="form-addons">
                                <input type="text" name="username" autocomplete="off" placeholder="Enter your username">
                                <img src="{{ asset('img/icons/users1.svg') }}" alt="img">
                            </div>
                            @error('username') <span class="text-danger">{{ $message }}</span>  @enderror
                        </div>
                        <div class="form-login">
                            <label>Password</label>
                            <div class="pass-group">
                                <input type="password" name="password" autocomplete="off" class="pass-input" placeholder="Enter your password">
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                            @error('password') <span class="text-danger">{{ $message }}</span>  @enderror
                        </div>
                        <div class="form-login">
                            <div class="alreadyuser">
                                <h4><a href="forgetpassword.html" class="hover-a">Forgot Password?</a></h4>
                            </div>
                        </div>
                        <div class="form-login">
                            <button class="btn btn-login" type="submit">Sign In</button>
                        </div>

                        <div class="form-setlogin">
                            <span>Factory Management System Designed Tokensoft ICT {{ date('Y') }} - 08130610626</span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="login-img">
                <img src="{{ asset('img/login.jpg') }}" alt="img">
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

<script src="{{ asset('js/feather.min.js') }}"></script>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
