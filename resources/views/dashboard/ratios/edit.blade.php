@extends('layouts.template')

@section('another_CSS')
<link rel="stylesheet" href="{{asset('css/datatable/dataTables.checkboxes.css')}}">
<link rel="stylesheet" href="{{asset('css/select2-bootstrap-5-theme.min.css')}}">
@endsection

@section('content')
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Édition des coefficients</h4>
    </div>

    <div class="card py-5">
        <form action="{{route('ratio.update',$ratio) }}" method="POST">
            @csrf
            @method('put')
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="classroom" class="font-medium form-label fs-16 text-label">
                            Classe
                        </label>
                        <select class="form-select bg-form" name="classroom" id="classroom"
                            aria-label="Sélectionnez une classe">
                            <option selected disabled class="text-secondary">Choisissez la classe</option>
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}" {{ $classroom->id == $ratio->classroom_id ? 'selected' :'' }}>{{$classroom->classroom}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="subject" class="font-medium form-label fs-16 text-label">
                            Matière
                        </label>
                        <select class="form-select bg-form" name="subject" id="subject"
                            aria-label="Sélectionnez une matière">
                            <option selected disabled class="text-secondary">Choisissez la matière</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $subject->id == $ratio->subject_id ? 'selected' :'' }}>{{$subject->subject}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-12 mb-3">
                        <label for="ratio" class="font-medium fs-16 text-black form-label">
                            Coefficient
                        </label>
                        <input type="number" step="0.1" name="ratio" id="ratio" class="form-control bg-form"
                            placeholder="Entrez le coefficient" aria-describedby="ratioHelp"  value="{{$ratio->ratio}}">
                    </div>

                    <div class="row d-flex justify-content-center mt-2">
                        <button type="reset" class="btn bg-secondary w-auto me-2 text-white">Annuler</button>
                        <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
                    </div>

                </div>
            </div>
        </form>
    </div>

    </div>
@endsection

