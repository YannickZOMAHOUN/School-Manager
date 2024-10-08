@extends('layouts.template')
@section('another_CSS')
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.checkboxes.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}">
@endsection

@section('content')
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Modifier une note</h4>
    </div>
    <div class="card py-5">
        <form id="note-form" action="{{ route('note.update', $note->id) }}" method="POST"  enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4 mb-3">
                        <label for="year_id">Année scolaire:</label>
                        <select name="year_id" id="year_id" class="form-control" required>
                            @foreach($years as $year)
                                <option value="{{ $year->id }}" {{ $year->id == old('year_id', $note->recording->first()->year_id) ? 'selected' : '' }}>
                                    {{ $year->year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="classroom">Classe:</label>
                        <select class="form-select bg-form" name="classroom_id" id="classroom_id" aria-label="Default select example">
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}" {{ $classroom->id == old('classroom_id', $note->recording->first()->classroom_id) ? 'selected' : '' }}>
                                    {{ $classroom->classroom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="student" class="font-medium form-label fs-16 text-label">Élève</label>

                       <input type="text"  name="student" id="student" class="form-control bg-form" placeholder="" value="{{ $note->recording->student->name }} {{ $note->recording->student->surname }}">
                    </div>
                </div>
                <div class="row">

                    <div class="col-12 col-md-3 mb-3">
                        <label for="subject" class="font-medium form-label fs-16 text-label">Matière</label>
                        <select class="form-select bg-form" name="subject" id="subject" aria-label="Sélectionnez une matière">
                            <option selected disabled class="text-secondary">Sélectionnez la matière</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ $subject->id == old('subject_id', $note->subject_id) ? 'selected' : '' }}>
                                    {{ $subject->subject }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <label for="ratio" class="font-medium form-label fs-16 text-label">Coefficient</label>
                        <input type="number" name="ratio" id="ratio" class="form-control bg-form" readonly value="{{ $note->ratio->ratio }}">
                        <input type="hidden" name="ratio_id" id="ratio_id"> <!-- Champ caché pour ratio_id -->
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <label for="semester" class="font-medium form-label fs-16 text-label">Semestre</label>
                        <select class="form-select bg-form" name="semester" id="semester">
                            <option selected disabled class="text-secondary">Choisissez le semestre</option>
                            <option value="1" {{ old('semester', $note->semester) == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('semester', $note->semester) == 2 ? 'selected' : '' }}>2</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <label for="note" class="font-medium fs-16 text-black form-label">Moyenne non coefficiée</label>
                        <input type="number" step="any" name="note" id="note" class="form-control bg-form" placeholder="Entrez la note" value="{{ $note->note }}">
                    </div>
                </div>

                <div class="row d-flex justify-content-center mt-2">
                    <button type="reset" class="btn bg-secondary w-auto me-2 text-white">Annuler</button>
                    <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<!-- Bootstrap JS (v5) -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript">
   document.getElementById('subject').addEventListener('change', function () {
    var subjectId = this.value;
    // Appel AJAX pour récupérer le coefficient basé sur la matière sélectionnée
    fetch(`/api/get-ratio/${subjectId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('ratio').value = data.ratio;
            document.getElementById('ratio_id').value = data.ratio_id;
        });
});

</script>
@endsection
