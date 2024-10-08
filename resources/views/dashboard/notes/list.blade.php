@extends('layouts.template')

@section("another_CSS")
<link rel="stylesheet" href="{{ asset('css/datatable/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.bootstrap4.min.css') }}">
@endsection

@section("content")

<div class="d-flex justify-content-between my-2 flex-wrap">
    <div class="text-color-avt fs-22 font-medium">Note(s) des élèves</div>
</div>

<!-- Formulaire de sélection de la classe et de l'année scolaire -->
<form method="GET" action="{{ route('note.index') }}" class="mb-4" id="filterForm">
    <div class="row">
        <div class="col-12 col-md-3 mb-3">
            <label for="year" class="font-medium form-label fs-16 text-label">
                Année Scolaire
            </label>
            <select class="form-select bg-form" name="year" id="year" aria-label="Sélectionnez l'année scolaire">
                <option selected disabled class="text-secondary">Choisissez l'année scolaire</option>
                @foreach ($years as $year)
                    <option value="{{ $year->id }}">{{ $year->year }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="classroom" class="font-medium form-label fs-16 text-label">
                Classe
            </label>
            <select class="form-select bg-form" name="classroom" id="classroom" aria-label="Sélectionnez une classe">
                <option selected disabled class="text-secondary">Choisissez la classe</option>
                @foreach ($classrooms as $classroom)
                    <option value="{{ $classroom->id }}">{{ $classroom->classroom }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-12 col-md-3 mb-3">
            <label for="subject" class="font-medium form-label fs-16 text-label">Matière</label>
            <select class="form-select bg-form" name="subject" id="subject" aria-label="Sélectionnez une matière">
                <option selected disabled class="text-secondary">Sélectionnez la matière</option>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->subject }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="semester" class="font-medium form-label fs-16 text-label">Semestre</label>
            <select class="form-select bg-form" name="semester" id="semester">
                <option selected disabled class="text-secondary">Choisissez le semestre</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>
    </div>
</form>

<div class="card p-3">
    <div class="table-responsive">
        <table class="table mt-3" id="students">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom(s)</th>
                    <th>Moyenne Non Coefficiée</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Les lignes seront chargées dynamiquement ici -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal de suppression générique -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer cet élève ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<!-- Bootstrap JS (v5) -->
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
    const classroomSelect = document.getElementById('classroom');
    const yearSelect = document.getElementById('year');
    const subjectSelect = document.getElementById('subject');
    const semesterSelect = document.getElementById('semester');

    [classroomSelect, yearSelect, subjectSelect, semesterSelect].forEach(select => {
        select.addEventListener('change', loadStudents);
    });

    function loadStudents() {
        const classroom = classroomSelect.value;
        const year = yearSelect.value;
        const subject = subjectSelect.value;
        const semester = semesterSelect.value;

        if (classroom && year && subject && semester) {
            fetch(`{{ route('notes.load') }}?classroom=${classroom}&year=${year}&subject=${subject}&semester=${semester}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#students tbody');
                    tbody.innerHTML = '';

                    data.forEach(note => {
                        let showUrl = '{{ route("note.show", ":id") }}'.replace(':id', note.recording.student.id);
                        let editUrl = '{{ route("note.edit", ":id") }}'.replace(':id', note.id);
                        let deleteUrl = '{{ route("note.destroy", ":id") }}'.replace(':id', note.id);

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${note.recording.student.name}</td>
                            <td>${note.recording.student.surname}</td>
                            <td>${note.note}</td>
                            <td>
                                <a class="text-decoration-none text-secondary" href="${showUrl}" title="Voir les détails de l'élève">
                                    <i class="fas fa-eye"></i>
                                </a>
                                &nbsp;
                                <a href="${editUrl}" class="btn btn-sm btn-primary">Modifier la note</a>
                                <button type="button" class="btn btn-sm btn-danger delete-button" data-id="${note.id}">
                                    Supprimer
                                </button>
                            </td>
                        `;
                        tbody.appendChild(tr);
                    });

                    document.querySelectorAll('.delete-button').forEach(button => {
                        button.addEventListener('click', function () {
                            const noteId = this.getAttribute('data-id');
                            const deleteUrl = '{{ route("note.destroy", ":id") }}'.replace(':id', noteId);
                            document.getElementById('deleteForm').setAttribute('action', deleteUrl);
                            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
                            deleteModal.show();
                        });
                    });
                });
        }
    }
});
</script>

@endsection
