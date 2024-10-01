@extends('emails.template')
@section('content')
<h2>Bonjour, M./Mme {{ $name }} {{ $surname }}</h2>
<p style='font-size:1.1em;'>
    Voici votre code pour valider la connexion à votre compte SCHOOL MANAGER <br>
     <b style='color:red;'> &#x26A0; Attention, le code a une validité de 10 minutes </b>
</p>
 <p style='margin-top:30px;margin-bottom:30px;'></p>
<p style='width:45%;margin:auto;padding:15px;background-color:#2962E6; color:#fff;border-radius:5px;text-align:center'>
<b style='font-size:1.8em;font-weight:500;'>{{ $code }}</b> </p>
@endsection


