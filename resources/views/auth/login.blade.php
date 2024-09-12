@extends('layouts.authentification')

@section('content')
<form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="email" class="form-label font-medium text-color-avt">Email</label>
        <input type="text" class="form-control rounded-pill py-2" name="email">

        @if($errors->has('email'))
        <span class="text-danger fs-12">{{ $errors->first('email') }}</span>
        @endif
    </div>
    <div class="mb-3">
        <label for="password" class="form-label font-medium text-color-avt">Mot de passe</label>
        <input type="password" class="form-control rounded-pill py-2" name="password">

        @if($errors->has('password'))
        <span class="text-danger fs-12">{{ $errors->first('password') }}</span>
        @endif
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="remember" name="remember">
        <label class="form-check-label" for="remember">
            {{ __('Se souvenir de moi') }}
        </label>
    </div>
    <div class="py-2 mb-3">
        <button type="submit" class="btn btn-avt-2 d-block w-100 py-2 rounded-pill"> {{ __('Se connecter') }} </button>
    </div>
</form>

<div class="text-center">
    <a href="{{ route('register') }}" class="text-color-avt">
        {{ __('Créer un nouveau compte') }}
    </a>

    <span class="mx-2">|</span>

    <a href="{{ route('school.create') }}" class="text-color-avt">
        {{ __('Créer une école') }}
    </a>
</div>
@endsection
