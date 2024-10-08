@extends('emails.template')

@section('content')
    <h2 style="font-size: 1.5em; font-weight: 600; color: #333; text-align: center;">
        Bonjour, M./Mme {{ $name }} {{ $surname }}
    </h2>

    <p style="font-size: 1.1em; line-height: 1.6; color: #333; text-align: center;">
        Voici votre code pour valider la connexion à votre compte <strong>SCHOOL MANAGER</strong>.
        <br>
        <b style="color: #d32f2f; font-size: 1.1em;">&#x26A0; Attention, ce code est valide pendant 10 minutes seulement.</b>
    </p>

    <div style="margin: 30px 0; text-align: center;">
        <p style="display: inline-block; width: 60%; padding: 15px; background-color: #2962E6; color: #fff;
        border-radius: 8px; font-size: 1.8em; font-weight: 500; letter-spacing: 2px; text-align: center;">
            {{ $code }}
        </p>
    </div>

    <p style="text-align: center; font-size: 1em; color: #888;">
        Si vous n'avez pas initié cette demande, veuillez ignorer cet email.
    </p>
@endsection
