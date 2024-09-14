@extends('layouts.template')

@section('content')

<div class="row col-12  pb-5">
    <div class="my-3">
        <h4 class="font-medium  text-color-avt">Importation de la liste des élèves</option>
        </h4>
    </div>

    <div class="card py-5">
        <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="classroom_id">Classe:</label>
                    <select name="classroom_id" id="classroom_id" class="form-control" required>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">{{ $classroom->classroom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="year_id">Année scolaire:</label>
                    <select name="year_id" id="year_id" class="form-control" required>
                        @foreach($years as $year)
                            <option value="{{ $year->id }}">{{ $year->year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="file">Fichier des élèves:</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>

            <div class="row d-flex justify-content-center mt-2">
                <button type="reset" class="btn bg-secondary w-auto me-2 text-white">Annuler</button>
                <button type="submit"  class="btn btn-success w-auto">Importer la liste des élèves</button>
            </div>
        </form>
     </div>

</div>
<div class="row col-12  pb-5">
    <div class="my-3">
        <h4 class="font-medium  text-color-avt">Ajouter un élève</option>
        </h4>
    </div>

    <div class="card py-5">
        <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="classroom_id">Classe:</label>
                    <select name="classroom_id" id="classroom_id" class="form-control" required>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">{{ $classroom->classroom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="year_id">Année scolaire:</label>
                    <select name="year_id" id="year_id" class="form-control" required>
                        @foreach($years as $year)
                            <option value="{{ $year->id }}">{{ $year->year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="matricue">Matricule</label>
                    <input type="text" name="matricule" id="matricule" class="form-control bg-form " >
                </div>
                <div class="col-md-6">
                    <label for="sex" class="form-label font-medium text-color-avt">Sexe</label>
                    <select name="sex" id="sex" class="form-control " required>
                        <option value="M" {{ old('sex') == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ old('sex') == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="name" class="form-label font-medium text-color-avt">Nom de l'élève</label>
                    <input type="text" name="name" id="name" class="form-control bg-form " >
                </div>
                <div class="col-md-6">
                    <label for="surname" class="form-label font-medium text-color-avt">Prénom</label>
                    <input type="text" name="surname" id="surname" class="form-control bg-form " >                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="birthday" class="form-label font-medium text-color-avt">Date de Naissance</label>
                    <input type="date" name="birthday" id="birthday" class="form-control bg-form " >
                </div>
                <div class="col-md-6">
                    <label for="birthplace" class="form-label font-medium text-color-avt">Lieu de Naissance</label>
                    <input type="text" name="birthplace" id="birthplace" class="form-control bg-form " >                </div>
            </div>
            <div class="row d-flex justify-content-center mt-2">
                <button type="reset" class="btn bg-secondary w-auto me-2 text-white">Annuler</button>
                <button type="submit"  class="btn btn-success w-auto">Enregistrer</button>
            </div>
        </form>
     </div>

</div>
@endsection
