<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login - PT Venus Tekindo</title>

    <link href="{{ asset('sbadmin2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="{{ asset('sbadmin2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        /* Mengatur ukuran logo */
        .login-logo {
            max-width: 150px; 
            height: auto;
        }
        
        /* PERBAIKAN: Container khusus untuk logo */
        /* Memberikan latar belakang warna Primary (Biru) agar logo putih terlihat */
        .logo-container {
            background-color: #4e73df; /* Warna biru khas SB Admin */
            padding: 20px;
            border-radius: 15px; /* Membuat sudut melengkung */
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-8 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    
                                    <div class="text-center">
                                        <div class="logo-container">
                                            <img src="{{ asset('images/logoVenus.png') }}" alt="Logo Venus Tekindo" class="login-logo">
                                        </div>
                                        
                                        <h1 class="h4 text-gray-900 mb-2">Selamat Datang</h1>
                                        <p class="mb-4">di Sistem <strong>PT Venus Tekindo</strong></p>
                                        
                                        @if ($errors->any())
                                            <div class="alert alert-danger small">
                                                @foreach ($errors->all() as $error)
                                                    <div>{{ $error }}</div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    <form class="user" method="POST" action="{{ route('login') }}">
                                        @csrf

                                        {{-- Input Username --}}
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="username" name="username" 
                                                placeholder="Username" 
                                                value="{{ old('username') }}" required autofocus>
                                        </div>
                                        
                                        {{-- Input Password --}}
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="password" name="password" 
                                                placeholder="Password" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                    </form>

                                    <hr>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('sbadmin2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('sbadmin2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <script src="{{ asset('sbadmin2/js/sb-admin-2.min.js') }}"></script>

</body>
</html>