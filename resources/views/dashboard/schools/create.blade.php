@extends('layouts.authentification')

@section('content')
<form action="{{ route('school.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="school" class="form-label font-medium text-color-avt">Nom de l'établissement</label>
        <input type="text" class="form-control rounded-pill py-2" id="school" name="school" value="{{ old('school') }}" required>
        @if($errors->has('school'))
            <span class="text-danger">{{ $errors->first('school') }}</span>
        @endif
    </div>

    <div class="mb-3">
        <label for="role_name" class="form-label font-medium text-color-avt">Fonctions disponibles</label>
        <input type="text" class="form-control rounded-pill py-2" id="role_name" name="role_name" value="{{ old('role_name') }}" placeholder="Exemple : Directeur; Enseignant; Surveillant" required>
        @if($errors->has('role_name'))
            <span class="text-danger">{{ $errors->first('role_name') }}</span>
        @endif
    </div>

    <div class="py-2 mb-3">
        <button type="submit" class="btn btn-avt-2 d-block w-100 py-2 rounded-pill">Créer l'établissement</button>
    </div>
</form>
@endsection
