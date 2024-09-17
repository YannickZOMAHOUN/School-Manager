@extends('layouts.template')

@section('another_CSS')
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.checkboxes.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}">
@endsection

@section('content')
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Ajouter les notes</h4>
    </div>
    <div class="card py-5">
        <form id="note-form" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="year" class="font-medium form-label fs-16 text-label">Année Scolaire</label>
                        <select class="form-select bg-form" name="year" id="year" aria-label="Sélectionnez l'année scolaire">
                            <option selected disabled class="text-secondary">Choisissez l'année scolaire</option>
                            @foreach ($years as $year)
                                <option value="{{ $year->id }}">{{ $year->year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="classroom" class="font-medium form-label fs-16 text-label">Classe</label>
                        <select class="form-select bg-form" name="classroom" id="classroom" aria-label="Sélectionnez une classe">
                            <option selected disabled class="text-secondary">Choisissez la classe</option>
                            @foreach ($classrooms as $classroom)
                                <option value="{{ $classroom->id }}">{{ $classroom->classroom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-4 mb-3">
                        <label for="subject" class="font-medium form-label fs-16 text-label">Matière</label>
                        <select class="form-select bg-form" name="subject" id="subject" aria-label="Sélectionnez une matière">
                            <option selected disabled class="text-secondary">Sélectionnez la matière</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="ratio" class="font-medium form-label fs-16 text-label">Coefficient</label>
                        <input type="number" name="ratio" id="ratio" class="form-control bg-form" readonly>
                        <input type="hidden" name="ratio_id" id="ratio_id"> <!-- Champ caché pour ratio_id -->
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="semester" class="font-medium form-label fs-16 text-label">Semestre</label>
                        <select class="form-select bg-form" name="semester" id="semester">
                            <option selected disabled class="text-secondary">Choisissez le semestre</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
                <table class="table mt-3" id="notes-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom(s)</th>
                            <th>Moyenne</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr></tr>
                    </tbody>
                </table>
                <div class="row d-flex justify-content-center mt-2">
                    <button type="reset" class="btn bg-secondary w-auto me-2 text-white">Annuler</button>
                    <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<script type="text/javascript">
$(document).ready(function () {
    // Charger les élèves automatiquement et mettre à jour le tableau
    $('#year, #classroom').change(function () {
        let yearId = $('#year').val();
        let classroomId = $('#classroom').val();
        if (yearId && classroomId) {
            $.ajax({
                url: '{{ route("get.students") }}', // Route pour récupérer les élèves
                type: 'GET',
                data: {year_id: yearId, classroom_id: classroomId},
                success: function (data) {
                    $('#notes-table tbody').empty(); // Vider le tableau avant d'ajouter les nouvelles données
                    data.forEach(function (student) {
                        let row = `<tr>
                            <td>${student.name}</td>
                            <td>${student.surname}</td>
                            <td><input type="number" name="averages[${student.id}]" class="form-control bg-form moyenne-coeff" data-student-id="${student.id}" required></td>
                        </tr>`;
                        $('#notes-table tbody').append(row);
                    });
                },
                error: function () {
                    alert('Une erreur est survenue lors du chargement des élèves.');
                }
            });
        }
    });

    // Calculer la moyenne coefficiée
    $(document).on('input', '.moyenne-coeff', function () {
        let coefficient = $('#ratio').val(); // Le coefficient est chargé lorsque la matière est sélectionnée
        let moyenne = $(this).val();
        if (moyenne && coefficient) {
            let moyenneCoeff = moyenne * coefficient;
            console.log(`Moyenne Coefficiée: ${moyenneCoeff}`);
        }
    });

    // Soumission AJAX sans rechargement de la page
    $('#note-form').submit(function (e) {
        e.preventDefault(); // Empêcher le rechargement de la page

        // Remplacer les champs vides par 0 avant de soumettre
        $('.moyenne-coeff').each(function () {
            if ($(this).val() === '') {
                $(this).val(0); // Remplacer les champs vides par 0
            }
        });

        $.ajax({
            url: '{{ route("note.store") }}',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                alert('Les notes ont été enregistrées avec succès.');

                // Réinitialiser les champs autres que Année Scolaire et Classe
                $('#subject').val('').trigger('change');
                $('#semester').val('').trigger('change');
                $('#ratio').val('');
                $('#ratio_id').val('');
                $('#notes-table tbody').empty();
            },
            error: function () {
                alert('Une erreur est survenue lors de l\'enregistrement des notes.');
            }
        });
    });

    // Charger le coefficient automatiquement lorsqu'une matière est sélectionnée
    $('#subject').change(function () {
        let subjectId = $(this).val();
        let classroomId = $('#classroom').val();
        let yearId = $('#year').val();
        let semester = $('#semester').val();
        if (subjectId && classroomId) {
            $.ajax({
                url: '{{ route("get.ratio") }}',
                type: 'GET',
                data: {subject_id: subjectId, classroom_id: classroomId},
                success: function (data) {
                    $('#ratio').val(data.ratio); // Remplir le coefficient
                    $('#ratio_id').val(data.ratio_id); // Remplir le champ caché pour ratio_id

                    // Vérifier si des notes existent pour cette matière et ce semestre
                    if (yearId && semester) {
                        $.ajax({
                            url: '{{ route("get.notes") }}',
                            type: 'GET',
                            data: {
                                year_id: yearId,
                                classroom_id: classroomId,
                                subject_id: subjectId,
                                semester: semester
                            },
                            success: function (response) {
                                console.log(note);
                                $('#notes-table tbody').empty(); // Vider le tableau avant d'ajouter les nouvelles données
                                response.forEach(note => {
                                    let row = `<tr>
                                        <td>${note.student_name}</td>
                                        <td>${note.student_surname}</td>
                                        <td><input type="number" name="averages[${note.student_id}]" class="form-control bg-form moyenne-coeff" value="${note.note}" readonly></td>
                                    </tr>`;
                                    $('#notes-table tbody').append(row);
                                });
                            },
                            error: function () {
                                alert('Une erreur est survenue lors du chargement des notes.');
                            }
                        });
                    }
                },
                error: function () {
                    alert('Une erreur est survenue lors du chargement du coefficient.');
                }
            });
        }
    });

    // Naviguer entre les champs avec la touche "Enter"
    $(document).on('keydown', '.moyenne-coeff', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Empêcher la soumission du formulaire
            let nextInput = $(this).closest('tr').next().find('.moyenne-coeff');
            if (nextInput.length) {
                nextInput.focus(); // Se déplacer vers le prochain champ
            } else {
                // Si c'est le dernier champ, passer au bouton de soumission
                $('button[type="submit"]').focus();
            }
        }
    });
});
</script>

@endsection
