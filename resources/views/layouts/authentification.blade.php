<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SONAB</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,700;1,500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">


</head>

<body>
    <div class="login-wrapper">

        <img src="{{ asset('images/sonab.jpg') }}" alt="logo" class="logo-icone">
        <h1 class=" text-white text-center mb-4 fs-22 font-bold ">GESTION DES DONNES DE BALIVAGE</h1>
        <div class="login-wrapper-content card shadow p-5 login-border">

            @yield('content')

        </div>

    </div>
</body>

</html>
