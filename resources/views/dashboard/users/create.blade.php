
@extends('layouts.template')
@section('content')
<section class="section profile">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Mon profil</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Modification</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Mot de passe</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2">
                        <!-- Profile Overview Tab -->
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label">Nom</div>
                                <div class="col-lg-9 col-md-8">{{ auth()->user()->staff->name }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label">Prénom(s)</div>
                                <div class="col-lg-9 col-md-8">{{ auth()->user()->staff->surname }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label">Sexe</div>
                                <div class="col-lg-9 col-md-8">
                                    @if (auth()->user()->staff->sex == 'M')
                                        Masculin
                                    @elseif (auth()->user()->staff->sex == 'F')
                                        Féminin
                                    @else
                                        Non spécifié
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label">Téléphone</div>
                                <div class="col-lg-9 col-md-8">{{ auth()->user()->staff->number }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">{{ auth()->user()->email }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-3 col-md-4 label">Rôle</div>
                                <div class="col-lg-9 col-md-8">{{ auth()->user()->staff->role->role_name }}</div>
                            </div>
                        </div>

                        <!-- Profile Edit Tab -->
                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Nom Field -->
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="nom" class="form-label fs-16 font-medium">Nom</label>
                                        <input type="text" class="form-control fs-14" name="nom" value="{{ auth()->user()->staff->name }}">
                                    </div>

                                    <!-- Prénom Field -->
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="prenom" class="form-label fs-16 font-medium">Prénom(s)</label>
                                        <input type="text" class="form-control fs-14" name="prenom" value="{{ auth()->user()->staff->surname }}">
                                        @error('prenom')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Téléphone Field -->
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="telephone" class="form-label fs-16 font-medium">Téléphone</label>
                                        <input type="number" class="form-control" name="telephone" value="{{ auth()->user()->staff->number }}">
                                        @error('telephone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Email Field -->
                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="email" class="form-label fs-16 font-medium">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="row d-flex justify-content-center mt-2">
                                    <button type="reset" class="btn btn-secondary w-auto me-2 text-white">Annuler</button>
                                    <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <form action="" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-lg-3 col-md-4 label">Mot de passe actuel</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input type="password" class="form-control" name="currentPassword" id="currentPassword">
                                        @error('currentPassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-lg-3 col-md-4 label">Nouveau mot de passe</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input type="password" class="form-control" name="newPassword" id="newPassword">
                                        @error('newPassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="renewPassword" class="col-lg-3 col-md-4 label">Confirmer le nouveau mot de passe</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input type="password" class="form-control" name="renewPassword" id="renewPassword">
                                        @error('renewPassword')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="row d-flex justify-content-center mt-2">
                                    <button type="reset" class="btn btn-secondary w-auto me-2 text-white">Annuler</button>
                                    <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- End Bordered Tabs -->
            </div>
        </div>
    </div>
</section>
@endsection
