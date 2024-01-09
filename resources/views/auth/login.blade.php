<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel Login | Urban Clap</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/css/admin_login.css') }}">
</head>

<body>
    <div class="workSpace">
        <div class="avatar" style="background: white;">
            <div id="infinity">
               <img src="{{ asset('admin-assets/images/optishinelogo.png')}}" style="margin-top: 28px;height: 90px" alt="">
            </div>
        </div>
        <div class="left">
            <img class="img-fluid" src="{{ asset('admin-assets/images/optishine.png') }}" alt="">
            <h1 class="logo">Welcome to Urban Clap</h1>
            <!-- <p>Online MLM Portal
            </p> -->
        </div>
        <div class="right">
            <form action="{{ route('login') }}" id="" method="post">
                @csrf
                <h1>SignIn</h1>
                <p class="invalid-feedback" role="alert">
                    <strong id="Message"></strong>
                </p>
                @error('error')
                  <p class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                  </p>
               @enderror
                @error('email')
                <p class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </p>
                @enderror
                @error('password')
                <p class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </p>
                @enderror
                <input class="input" type="text" placeholder="Enter email" name="email" value="{{ old('email') }}"
                    required autocomplete="off">
                <input class="input" name="password" type="password" placeholder="Enter your password" required
                    autocomplete="off">
                <div class="login-btn-box">
                    <button class="submit">Log In</button>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('admin-assets/js/app.min.js')}}"></script> 

    <script>
        $(document).ready(function(){
            @if(Session::has('5fernsadminerror'))
               
                $('#Message').html("{{ Session::get('5fernsadminerror') }}");
            @elseif(Session::has('5fernsadminsuccess'))
                $('#Message').html("{{ Session::get('5fernsadminsuccess') }}");
            @endif
            });

    </script>
</body>

</html>