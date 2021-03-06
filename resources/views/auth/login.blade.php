<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>e-Ning Tasiah</title>

    <style>
        :root{
            --bg-url:url({{asset('/public/img/bg.svg')}});
        }
    </style>

    <!-- Custom fonts for this template-->
    <link href="{{asset('public/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('public/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/css/custom.css')}}" rel="stylesheet">

</head>

<body style="height:100vh; overflow:hidden;">
    <div class="bg">
        <img class="anak" id="anak1" style="height:200px;" src="{{asset('/public/img/anak1.svg')}}" alt="">
        <img class="anak" id="anak2" style="height:150px;" src="{{asset('/public/img/anak2.svg')}}" alt="">
        <img class="anak" id="anak3" style="height:300px;" src="{{asset('/public/img/anak3.svg')}}" alt="">
    </div>
    <!-- <div class="bg-pattern"> -->
    <div class="container">
        
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-8 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->    
                        <div class="p-5">
                            <div class="text-center">
                                <!-- <div class="sidebar-brand-icon rotate-n-15">
                                    <i class="fas fa-laugh-wink text-primary" style="font-size:40px"></i>
                                </div> -->
                                <img src="{{ asset('public/img/surabaya_logo.png') }}" alt="" width="77px">
                                <h1 class="h4 text-gray-900 mb-4">e-Ning Tasiah Surabaya</h1>
                            </div>
                            <form class="user" method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user {{ $errors->has('username') ? ' is-invalid' : '' }}"
                                        id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="Username" name="username" value="{{ old('username') }}" required autofocus>
                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        id="exampleInputPassword" placeholder="Password"
                                        name="password" required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <div style="position:fixed; bottom:0; right:0; margin: 10px;">
        <a href="http://www.freepik.com" style="color:white;">Designed by pch.vector / Freepik</a>
    </div>
    <!-- </div> -->
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('public/js/sb-admin-2.min.js')}}"></script>

</body>

</html>