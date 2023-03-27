<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <style>
        body {
            background: #100F0D;
            font-family: 'Vollkorn', serif;
        }

        .btn-purple {
            background: #100F0D;
            width: 100%;
            color: #fff;
        }

    </style>

    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 mt-5">
                <div class="container-fluid d-flex mt-5 mb-0">
                    <img src="{{ asset('assets/img/desacibeureum.png') }}" width="70" height="70" alt="no img">
                    <div class="">
                    <h3 class="text-center text-white">ANKAT</h3>
                    <P class="text-center text-white mb-0">Aplikasi Pengaduan Masyarakat</P>
                    </div>
                </div>
                <div class="card mt-5">
                    <div class="card-body">
                        <h2 class="text-center mb-4">LOGIN</h2>
                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="username" placeholder="Username" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="Password" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-purple">MASUK</button>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</body>

</html>
