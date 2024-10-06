<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>School Manager</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Include CSS files -->
  @include("layouts.css")

  <!-- Additional CSS -->
  @yield("another_CSS")

  <style>
    #spinner {
      position: fixed;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: rgba(0, 0, 0, 0.25);
      z-index: 20000;
    }
  </style>
</head>

<body>
  <main>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card">
            <div class="card-header text-center">{{ __('Créez votre profil') }}</div>
            <div class="card-body">

              <!-- Display success message -->
              @if(session('success'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
              @endif

              <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf
                <h1>{{ $school_name }}</h1>
                <input type="hidden" id="school_id" name="school_id" value="{{ old('school_id', $school_id ?? '') }}">

                <!-- Selection de la fonction (rôle) -->
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="role_id" class="form-label">Fonction :</label>
                    <select name="role_id" id="role_id" class="form-control" required>
                      <option value="">Sélectionnez une fonction</option>
                    </select>
                  </div>

                  <!-- Sélection du sexe -->
                  <div class="col-md-6">
                    <label for="sex" class="form-label">Sexe :</label>
                    <select name="sex" id="sex" class="form-control " required>
                      <option value="M" {{ old('sex') == 'M' ? 'selected' : '' }}>Masculin</option>
                      <option value="F" {{ old('sex') == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                    @error('sex')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <!-- Nom et prénom -->
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="name" class="form-label">Nom :</label>
                    <input id="name" type="text" class="form-control  @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                    @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="col-md-6">
                    <label for="surname" class="form-label">Prénom :</label>
                    <input type="text" name="surname" class="form-control  @error('surname') is-invalid @enderror" id="surname" value="{{ old('surname') }}" required>
                    @error('surname')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <!-- Email et numéro de téléphone -->
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                    @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="col-md-6">
                    <label for="number" class="form-label">Numéro de téléphone :</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">+229</span>
                      </div>
                      <input type="tel" name="number" class="form-control @error('number') is-invalid @enderror" id="number" value="{{ old('number') }}" required pattern="[0-9]{8}" placeholder="Ex: 91000000">
                    </div>
                    @error('number')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                </div>

                <!-- Mot de passe et confirmation -->
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input id="password" type="password" class="form-control  @error('password') is-invalid @enderror" name="password" required>
                    @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                  </div>
                  <div class="col-md-6">
                    <label for="password-confirm" class="form-label">Confirmation du mot de passe :</label>
                    <input id="password-confirm" type="password" class="form-control " name="password_confirmation" required>
                  </div>
                </div>

                <!-- Bouton d'inscription -->
                <div class="row mb-0">
                  <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary rounded-pill">S'inscrire</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Include JS files -->
  @include("layouts.js")

  <!-- AJAX script for loading roles -->
  <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      var schoolId = $('#school_id').val(); // Obtenir l'ID de l'école du champ hidden
      if (schoolId) {
        loadRoles(schoolId); // Charger les rôles automatiquement
      }

      function loadRoles(schoolId) {
        var roleSelect = $('#role_id');
        roleSelect.prop('disabled', true).empty().append('<option value="">Chargement des rôles...</option>');

        $.ajax({
          url: '{{ route('getRoles') }}',
          method: 'GET',
          data: { school_id: schoolId },
          success: function(data) {
            roleSelect.empty().prop('disabled', false);
            $.each(data.roles, function(index, role) {
              roleSelect.append('<option value="' + role.id + '">' + role.role_name + '</option>');
            });
          },
          error: function() {
            roleSelect.empty().append('<option value="">Erreur lors du chargement des rôles</option>');
          }
        });
      }
    });
  </script>

  <!-- Script to validate password confirmation -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const password = document.getElementById('password');
      const passwordConfirm = document.getElementById('password-confirm');

      function checkPasswords() {
        const match = password.value === passwordConfirm.value;
        passwordConfirm.setCustomValidity(match ? '' : 'Les mots de passe ne correspondent pas');
      }

      passwordConfirm.addEventListener('input', checkPasswords);
    });
  </script>
</body>

</html>
