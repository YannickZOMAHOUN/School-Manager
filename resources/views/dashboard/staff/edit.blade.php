@extends('layouts.template')

@section('content')
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Ajouter un nouvel utilisateur</h4>
    </div>

    <div class="card py-5">
        <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="role_id">Fonction:</label>
                    <select name="role_id" id="role_id" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label font-medium text-color-avt">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label font-medium text-color-avt">Nom</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="surname" class="form-label font-medium text-color-avt">Prénom(s)</label>
                    <input type="text" name="surname" id="surname" class="form-control @error('surname') is-invalid @enderror" required>
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
                        <input type="tel" name="number" class="form-control @error('number') is-invalid @enderror" id="number" required placeholder="Ex: 91000000" pattern="[0-9]{8}">
                    </div>
                    @error('number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="sex" class="form-label font-medium text-color-avt">Sexe</label>
                    <select name="sex" id="sex" class="form-control @error('sex') is-invalid @enderror" required>
                        <option value="M" {{ old('sex') == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ old('sex') == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                    @error('sex')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="user_password" class="form-label font-medium text-color-avt">Mot de Passe</label>
                    <input id="user_password" type="password" class="form-control @error('user_password') is-invalid @enderror" name="user_password" required autocomplete="new-password">
                    @error('user_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password-confirm" class="form-label">Confirmer votre mot de passe</label>
                    <input id="password-confirm" type="password" class="form-control @error('user_password_confirmation') is-invalid @enderror" name="user_password_confirmation" required>
                    @error('user_password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div id="password-error" style="color: red; display: none;">Les mots de passe ne correspondent pas.</div>
            <div class="row d-flex justify-content-center mt-2">
                <button type="reset" class="btn bg-secondary w-auto me-2 text-white">Annuler</button>
                <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const password = document.getElementById('user_password');
        const passwordConfirm = document.getElementById('password-confirm');
        const passwordError = document.getElementById('password-error');
        const form = document.querySelector('form');

        // Fonction pour vérifier si les mots de passe correspondent
        function checkPasswords() {
            const passwordsMatch = password.value === passwordConfirm.value;
            passwordError.style.display = passwordsMatch ? 'none' : 'block';
            passwordConfirm.setCustomValidity(passwordsMatch ? '' : "Les mots de passe ne correspondent pas");
        }

        // Vérification à la frappe dans le champ de confirmation
        passwordConfirm.addEventListener('input', checkPasswords);

        // Vérification lors de la soumission du formulaire
        form.addEventListener('submit', function(event) {
            checkPasswords(); // Assurez-vous que la vérification a été effectuée
            if (!passwordConfirm.checkValidity()) {
                event.preventDefault(); // Empêche l'envoi si les mots de passe ne correspondent pas
            }
        });
    });
</script>
@endsection
