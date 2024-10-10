@extends('layouts.template')

@section('another_CSS')
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.checkboxes.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}">
@endsection

@section('content')

<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Impression des bulletins et Classement</h4>
    </div>
    <div class="card py-5">
        <form action="" method="POST" target="_blank" id="bulletins-form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="year_id" id="year_id">
                    <input type="hidden" name="classroom_id" id="classroom_id">
                    <input type="hidden" name="semester_hidden" id="semester_hidden">

                    <div class="col-12 col-md-4 mb-3">
                        <label for="year" class="font-medium form-label fs-16 text-label">Année Scolaire</label>
                        <select class="form-select bg-form" name="year" id="year" required aria-label="Sélectionnez l'année scolaire">
                            <option selected disabled class="text-secondary">Choisissez l'année scolaire</option>
                            @foreach ($years as $year)
                                <option value="{{ $year->id }}">{{ $year->year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label for="classroom" class="font-medium form-label fs-16 text-label">Classe</label>
                        <select class="form-select bg-form" name="classroom" id="classroom" required aria-label="Sélectionnez une classe">
                            <option selected disabled class="text-secondary">Choisissez la classe</option>
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->classroom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label for="semester" class="font-medium form-label fs-16 text-label">Semestre</label>
                        <select class="form-select bg-form" name="semester" id="semester" required>
                            <option selected disabled class="text-secondary">Choisissez le semestre</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <!-- Button to print the ranking -->
                <button type="button" class="btn btn-primary fs-14" id="print-ranking">
                    <i class="bi bi-printer"></i> Imprimer Classement
                </button>
                <!-- Button to print the bulletins -->
                <button type="button" class="btn btn-success fs-14" id="print-card">
                    <i class="bi bi-printer"></i> Imprimer Bulletins
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fill hidden fields with selected values
        document.getElementById('year').addEventListener('change', function() {
            document.getElementById('year_id').value = this.value;
        });

        document.getElementById('classroom').addEventListener('change', function() {
            document.getElementById('classroom_id').value = this.value;
        });

        document.getElementById('semester').addEventListener('change', function() {
            document.getElementById('semester_hidden').value = this.value;
        });

        // Function to reset the form
        function resetForm() {
            document.getElementById('year').selectedIndex = 0;
            document.getElementById('classroom').selectedIndex = 0;
            document.getElementById('semester').selectedIndex = 0;
            document.getElementById('year_id').value = '';
            document.getElementById('classroom_id').value = '';
            document.getElementById('semester_hidden').value = '';
        }

        // Generate ranking and open in a new window
        document.getElementById('print-ranking').addEventListener('click', function() {
            var form = document.querySelector('#bulletins-form');
            form.action = "{{ route('ranking.generate') }}";
            form.target = "_blank";
            form.submit();
            // resetForm(); // Uncomment if you want to reset the form after printing
        });

        document.getElementById('print-card').addEventListener('click', function() {
            var form = document.querySelector('#bulletins-form');
            form.action = "{{ route('bulletins.generate') }}";
            form.target = "_blank";
            form.submit();
            // resetForm(); // Uncomment if you want to reset the form after printing
        });
    });
</script>
@endsection
