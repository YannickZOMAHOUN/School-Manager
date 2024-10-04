<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap' rel='stylesheet'>
    <style>
        body {
            margin: 0;
            padding: 30px 0;
            font-family: 'Montserrat', sans-serif;
            background-color: #D3E3FD;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background-color: #333;
            padding: 20px;
            color: #fff;
        }

        .header img {
            width: 200px; /* Dimensions optimisées */
            height: auto;
            display: block;
        }

        .header a {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 5px;
            background-color: #2962E6;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            text-align: center;
        }

        .code-title {
            background-color: #2962E6;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .email-body {
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }

        .footer {
            background-color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #888;
            margin-bottom: 20px;
        }

        .footer hr {
            width: 40%;
            margin: 10px auto;
        }

        .footer h5 {
            margin: 10px 0;
            font-weight: 600;
        }

        .footer address {
            margin: 0;
            font-style: normal;
            color: #333;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Header de l'email -->
        <div class="header">
            <table style="width:100%;">
                <tr>
                    <td style="width: 65%;">
                        <img src="{{asset('images/logo.png')}}" alt='Logo ONG Vu'>
                    </td>
                    <td style="width: 35%;">
                        <a href='https://gestion.ongvu.org/user/login' target='_blank' aria-label="Se connecter au site">Se connecter</a>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Titre du code de validation -->
        <div class="code-title">
            <h1>CODE DE VALIDATION</h1>
        </div>

        <!-- Contenu de l'email -->
        <div class="email-body">
           @yield('content')
        </div>

        <!-- Footer de l'email -->
        <div class="footer">
            <hr>
            <h3>Nous contacter</h3>
            <table style="width:100%;">
                <tr>
                    <td>
                        <h5>Adresse</h5>
                        <address>Abomey, Bénin</address>
                    </td>
                    <td>
                        <h5>Télephone</h5>
                        <address>+229 -68 374 902</address>
                    </td>
                    <td>
                        <h5>Email</h5>
                        <address><a href='mailto:yannickzomahoun75@gmail.com'>yannickzomahoun75@gmail.com</a></address>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>
