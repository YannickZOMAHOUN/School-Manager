@extends('layouts.template')

@section('content')
<div class="row col-12 pb-5">
    <div class="d-flex justify-content-between my-2 flex-wrap">
        <div class="text-color-avt fs-22 font-medium">Modifier les informations de {{ $staff->name }} {{ $staff->surname }} : {{ $staff->role->role_name }}</div>
        <div>
            <a class="btn btn-success fs-14" href="{{ route('staff.index') }}">
                <i class="fas fa-list"></i> Liste du personnel
            </a>
        </div>
    </div>

    <div class="card py-5">
        <form action="{{ route('staff.update', $staff->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="role_id">Fonction:</label>
                    <select name="role_id" id="role_id" class="form-control" required>
                        @foreach ( $roles as $role)
                        <option value="{{ $role->id }}" {{ $role->id == old('role_id', $staff->role_id) ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label font-medium text-color-avt">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" required value="{{ $staff->user->email }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label font-medium text-color-avt">Nom</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required value="{{ $staff->name }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="surname" class="form-label font-medium text-color-avt">Prénom(s)</label>
                    <input type="text" name="surname" id="surname" class="form-control @error('surname') is-invalid @enderror" required value="{{ $staff->surname }}">
                    @error('surname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="number" class="form-label font-medium text-color-avt">Numéro de téléphone</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">+229</span>
                        </div>
                        <input type="tel" name="number" class="form-control @error('number') is-invalid @enderror" id="number" required placeholder="Ex: 91000000" pattern="[0-9]{8}" value="{{ $staff->number }}">
                    </div>
                    @error('number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="sex" class="form-label font-medium text-color-avt">Sexe</label>
                    <select name="sex" id="sex" class="form-control @error('sex') is-invalid @enderror" required>
                        <option value="M" {{ old('sex', $staff->sex) == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ old('sex', $staff->sex) == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                    @error('sex')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row d-flex justify-content-center mt-2">
                <button type="reset" class="btn bg-secondary w-auto me-2 text-white">Annuler</button>
                <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection
