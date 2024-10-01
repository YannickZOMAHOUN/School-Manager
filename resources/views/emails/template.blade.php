
<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
    </style>
</head>
<body style='margin: 0;
            padding: 0;
            padding-top:30px;
            padding-bottom:30px;
            font-family: Montserrat, sans-serif;
            background-color: #D3E3FD'>

    <div style='max-width: 600px;
            margin: 0 auto;
            margin-top:30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            overflow: hidden;'>
        <!-- Header de l'email -->
        <div style='margin:0;padding:0;'>
            <div style='width:100%;margin:0;padding:20px;background-color:#333;'>
                <table style='width:95%;margin:0;padding:0;'>
                    <tr>
                        <td style='width:65%;'>
                            <img src='https://cfpa.ongvu.org/wp-content/uploads/logo-mail/logo_ongvu_mail_bg_dark.png' alt='Logo_ongvu' style='width: 300px; height: auto; display: block;'>
                        </td>
                        <td style='width: 25%;margin-left:1%;margin-right:1%;'>
                            <a href='https://gestion.ongvu.org/user/login' target='_blank' style='font-weight:500;text-decoration:none;display:block;width:auto;height:30px;border-radius:5px;text-align:center;padding-top:8px;padding-bottom:3px;background-color:#2962E6;color:#fff;'>Se connecter</a>
                        </td>
                    </tr>
                </table>
            </div>
            <div style='width:100%;margin:0;padding:0;background-color:#2962E6;margin-top:-30px;'>
             <h1 style='padding:20px;color:#fff;text-align:center;'>CODE DE VALIDATION</h1>
            </div>
        </div>

        <!-- Contenu de l'email -->
        <div class='email-body' style='padding: 20px; color: #333;line-height: 1.6;'>
           @yield('content')
        </div>
        <!-- Footer de l'email -->
        <div style='background-color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #888;
            margin-bottom:20px;'>

            <div style='margin-top:10px;'>
            <hr style='width:40%;margin:auto;margin-top:10px;'>
                <h3 style='text-align:center'>Nous contacter</h3>
                <table style='width:100%;margin:0;padding:0;'>
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
    </div>

</body>
</html>
