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
        <label for="country_id" class="form-label font-medium text-color-avt">Pays</label>
        <select name="country_id" id="country_id" class="form-control rounded-pill py-2" required>
            <option value="">Sélectionnez un pays</option>
            @foreach($countries as $country)
                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
            @endforeach
        </select>
        @if($errors->has('country_id'))
            <span class="text-danger">{{ $errors->first('country_id') }}</span>
        @endif
    </div>

    <div class="mb-3">
        <label for="department_id" class="form-label font-medium text-color-avt">Département</label>
        <select name="department_id" id="department_id" class="form-control rounded-pill py-2" required>
            <option value="">Sélectionnez un département</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
            @endforeach
        </select>
        @if($errors->has('department_id'))
            <span class="text-danger">{{ $errors->first('department_id') }}</span>
        @endif
    </div>

    <div class="mb-3">
        <label for="city_id" class="form-label font-medium text-color-avt">Commune</label>
        <select name="city_id" id="city_id" class="form-control rounded-pill py-2" required>
            <option value="">Sélectionnez une commune</option>
            @foreach($cities as $city)
                <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
            @endforeach
        </select>
        @if($errors->has('city_id'))
            <span class="text-danger">{{ $errors->first('city_id') }}</span>
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

<script>
    document.getElementById('country_id').addEventListener('change', function() {
        const countryId = this.value;
        const departmentSelect = document.getElementById('department_id');
        const citySelect = document.getElementById('city_id');

        // Réinitialiser les sélecteurs
        departmentSelect.innerHTML = '<option value="">Sélectionnez un département</option>';
        citySelect.innerHTML = '<option value="">Sélectionnez une commune</option>';

        if (countryId) {
            fetch(`/departments/${countryId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(department => {
                        const option = document.createElement('option');
                        option.value = department.id;
                        option.textContent = department.name;
                        departmentSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erreur:', error));
        }
    });

    document.getElementById('department_id').addEventListener('change', function() {
        const departmentId = this.value;
        const citySelect = document.getElementById('city_id');

        // Réinitialiser le sélecteur des villes
        citySelect.innerHTML = '<option value="">Sélectionnez une commune</option>';

        if (departmentId) {
            fetch(`/cities/${departmentId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(city => {
                        const option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Erreur:', error));
        }
    });
</script>


@endsection
