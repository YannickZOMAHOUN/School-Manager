@extends('layouts.app')

@section('content')
    <h1>Gestion des lieux</h1>

    <form action="{{ route('locations.storeCountry') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nom du pays" required>
        <button type="submit">Créer un pays</button>
    </form>

    <form action="{{ route('locations.storeDepartment') }}" method="POST">
        @csrf
        <select name="country_id" required>
            <option value="">Sélectionnez un pays</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
        <input type="text" name="name" placeholder="Nom du département" required>
        <button type="submit">Créer un département</button>
    </form>

    <form action="{{ route('locations.storeCity') }}" method="POST">
        @csrf
        <select name="department_id" required>
            <option value="">Sélectionnez un département</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->name }}</option>
            @endforeach
        </select>
        <input type="text" name="name" placeholder="Nom de la commune" required>
        <button type="submit">Créer une commune</button>
    </form>
@endsection
