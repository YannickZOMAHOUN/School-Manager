@extends('layouts.authentification')

@section('content')
<form action="{{ route('school.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="school" class="form-label font-medium text-color-avt">Nom de l'établissement</label>
        <input type="text" class="form-control rounded-pill py-2" name="school">


    </div>
    <div class="py-2 mb-3">
        <button type="submit" class="btn btn-avt-2 d-block w-100 py-2 rounded-pill"> {{ __('Créer l`\école') }} </button>
    </div>
</form>
@endsection
