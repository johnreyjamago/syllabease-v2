<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SyllabEase</title>
    <link rel="stylesheet" href="/css/register.css">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/loading.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/Sample/se.png') }}">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="registercon">
                    <img class="syllab_logo" src="/assets/Sample/syllabease.png" alt="SyllabEase Logo">
                    <div class="regtext" id="title">Register</div>
                    <div class="formCon">
                        <div class="card-body">
                            <form id="register-form" method="POST" action="{{ route('register') }}">
                                @csrf

                                <label for="id" class="col-md-4 col-form-label text-md-end"></label>
                                <input id="id" type="text" placeholder="Employee Number" class="form-control @error('id') is-invalid @enderror" name="id" value="{{ old('id') }}" required autocomplete="id" autofocus>


                                <label for="firstname" class="col-md-4 col-form-label text-md-end"></label>
                                <input id="firstname" type="text" placeholder="Firstname" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>



                                <label for="lastname" class="col-md-4 col-form-label text-md-end"></label>
                                <input id="lastname" type="text" placeholder="Lastname" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

                                <div class="flex">
                                    <label for="prefix" class="col-md-4 col-form-label text-md-end"></label>
                                    <input id="prefix" type="text" placeholder="Prefix" class="form-control1 " name="prefix" value="{{ old('prefix') }}" autofocus>


                                    <label for="suffix" class="col-md-4 col-form-label text-md-end"></label>
                                    <input id="suffix" type="text" placeholder="Suffix" class="form-control2 " name="suffix" value="{{ old('suffix') }}" autofocus>

                                </div>

                                <label for="phone" class="col-md-4 col-form-label text-md-end"></label>
                                <input id="phone" type="text" placeholder="Phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" autofocus>


                                <label for="email" class="col-md-4 col-form-label text-md-end"></label>
                                <input id="email" type="email" placeholder="Email Address" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">


                                <label for="password" class="col-md-4 col-form-label text-md-end"></label>

                                <div class="col-md-6">
                                    <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">



                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end"></label>
                                    <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                                    <div class="errormessage">
                                        @foreach(['id', 'firstname', 'lastname', 'phone', 'email', 'password', 'suffix', 'prefix'] as $field)
                                        @error($field)
                                        <p class="" role="alert">
                                            {{ $message }}
                                        </p>
                                        @enderror
                                        @endforeach
                                    </div>

                                    <button type="submit" class="regbtn" id="register-button">
                                        {{ __('Register') }}
                                    </button>
                                    <div class="login">
                                        <a href="/login" id="haveAcc">Already Have an Account</a>
                                    </div>

                            </form>
                        </div>
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