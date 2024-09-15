
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>School Manager</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
        }

        #spinner:before {
            content: "";
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            z-index: 20000;
            background-color: rgba(0, 0, 0, 0.25);
        }
    </style>

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header text-center">{{ __('Créez votre profil') }}</div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="school_id" class="form-label font-medium text-color-avt">Ecole :</label>
                                    <input type="text" id="school_name" class="form-control rounded-pill py-2" value="{{ old('school_name', session('school_name') ?? '') }}" readonly>
                                    <input type="hidden" id="school_id" name="school_id" value="{{ old('school_id', session('school_id') ?? '') }}">
                                    @error('school_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="role_id" class="form-label font-medium text-color-avt">Fonction :</label>
                                    <select name="role_id" id="role_id" class="form-control rounded-pill py-2" required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->role_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label font-medium text-color-avt">{{ __('Nom') }}</label>
                                    <input id="name" type="text" class="form-control rounded-pill py-2 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="surname" class="form-label font-medium text-color-avt">Prénom</label>
                                    <input type="text" name="surname" class="form-control rounded-pill py-2 @error('surname') is-invalid @enderror" id="surname" value="{{ old('surname') }}" required>
                                    @error('surname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="sex" class="form-label font-medium text-color-avt">Sexe</label>
                                    <select name="sex" id="sex" class="form-control rounded-pill py-2" required>
                                        <option value="M" {{ old('sex') == 'M' ? 'selected' : '' }}>Masculin</option>
                                        <option value="F" {{ old('sex') == 'F' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                    @error('sex')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label font-medium text-color-avt">Email</label>
                                    <input type="email" name="email" class="form-control rounded-pill py-2 @error('email') is-invalid @enderror" id="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="number" class="form-label font-medium text-color-avt">Numéro de téléphone</label>
                                    <input type="text" name="number" class="form-control rounded-pill py-2 @error('number') is-invalid @enderror" id="number" value="{{ old('number') }}" required>
                                    @error('number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label font-medium text-color-avt">{{ __('Mot de Passe') }}</label>
                                    <input id="password" type="password" class="form-control rounded-pill py-2 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="password-confirm" class="form-label">{{ __('Confirmer votre mot de passe') }}</label>
                                    <input id="password-confirm" type="password" class="form-control rounded-pill py-2" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Enregistrer') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </main><!-- End #main -->
  <!-- Include JavaScript files -->
  @include("layouts.js")

  <!-- Additional JavaScript -->
  @yield("another_Js")

</body>

</html>
