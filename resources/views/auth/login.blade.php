<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/user_logins.css">
    <title>SyllabEase</title>
    <link rel="stylesheet" href="/css/loading.css">
    <script src="{{ asset('js/loading.js') }}" defer></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/Sample/se.png') }}">
</head>
<body>
<div class="container">
    <div class="login_container">
        <div class="bayanihanLeader_loginPage">
            <img class="syllab_logo" src="/assets/Sample/syllabease.png" alt="SyllabEase Logo">
            <div class="card">

                <div class="login_form">
                    <form method="POST" id = "form" action="{{ route('login') }}">
                        @csrf
                        <div class="email_ni">
                                <input id="email" placeholder="example@gmail.com" type="email" class="email_input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert"><br>
                                        <strong class="message_alert">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="pass_ni">
                                <input id="password" placeholder="password" type="password" class="pass_input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="message_alert">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="remember_container">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="login">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="login_btn">
                                    {{ __('Login') }}
                                </button><br>

                                @if (Route::has('password.request'))
                                    <a class="forgot_pass" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div><br><br>

                        <div class="register_container">
                            @if (Route::has('password.request'))
                                <a class="no_account" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="loading-screen">
        <div id="loading-spinner" class="flex">
            <div id="loading-box">
                <img src="/assets/Sample/loading.gif" alt="loading...">
            </div>
        </div>
    </div>
</body>
</html>
