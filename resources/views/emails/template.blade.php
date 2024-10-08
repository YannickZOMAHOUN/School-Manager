<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #333;
            padding: 20px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header img {
            max-width: 180px;
            height: auto;
        }

        .header a {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 5px;
            background-color: #2962E6;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            text-align: center;
            transition: background-color 0.3s;
        }

        .header a:hover {
            background-color: #1a4ab7;
        }

        .code-title {
            background-color: #2962E6;
            color: #fff;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .email-body {
            padding: 20px;
            color: #333;
            line-height: 1.6;
            font-size: 16px;
        }

        .footer {
            background-color: #f7f7f7;
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
            color: #333;
        }

        .footer address {
            margin: 0;
            font-style: normal;
            color: #333;
        }

        .footer a {
            color: #2962E6;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        /* Responsivité pour les petits écrans */
        @media (max-width: 600px) {
            .header {
                flex-direction: column;
                text-align: center;
            }

            .header img {
                margin-bottom: 10px;
            }

            .header a {
                width: 100%;
            }

            .footer table {
                width: 100%;
            }

            .footer table td {
                display: block;
                text-align: center;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Header de l'email -->
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo de l'ONG Vu">
            <a href="https://gestion.ongvu.org/user/login" target="_blank" aria-label="Se connecter au site">Se connecter</a>
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
            <table style="width: 100%;">
                <tr>
                    <td>
                        <h5>Adresse</h5>
                        <address>Abomey, Bénin</address>
                    </td>
                    <td>
                        <h5>Téléphone</h5>
                        <address>+229 68 374 902</address>
                    </td>
                    <td>
                        <h5>Email</h5>
                        <address><a href="mailto:yannickzomahoun75@gmail.com">yannickzomahoun75@gmail.com</a></address>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</body>

</html>
