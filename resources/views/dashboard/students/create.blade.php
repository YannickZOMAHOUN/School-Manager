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

            <button type="submit" class="btn btn-primary">Importer</button>
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
            </div>
            <button type="submit" class="btn btn-primary">Importer</button>
        </form>
     </div>

</div>
@endsection
