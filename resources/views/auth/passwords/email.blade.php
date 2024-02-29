<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/pass_reset.css">
    <title>Reset Password</title>
</head>
<body>
    

    <div class="container">
        <div class="">
            <div class="resetPass_container">
                <div class="card">
                    <img class="syllab_logo" src="/assets/Sample/syllabease.png" alt="SyllabEase Logo">
                    <div class="resetpass_text">{{ __('Reset Password') }}</div>

                    <div class="card_body">
                        @if (session('status'))
                            <div class="reset_message" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="row mb-3">

                                <div class="reset_pass_container">
                                    <input placeholder="Enter your email" id="email" type="email" class="resetpass_input" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus><br>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong class="invalid_text">{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div><br>

                            <div class="send_btn">
                                <button type="submit" class="btn_text">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>

                            <div class="backbtn">
                                <a class="goback" href="/login" id="haveAcc">Go Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>