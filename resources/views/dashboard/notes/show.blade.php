@extends('layouts.template')

@section('another_CSS')
<link rel="stylesheet" href="{{ asset('css/datatable/dataTables.checkboxes.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}">
@endsection

@section('content')
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Notes et Moyenne</h4>
    </div>
    <div class="card py-5">
        <form id="note-form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4 mb-3">
                        <label for="year" class="font-medium form-label fs-16 text-label">Année Scolaire</label>
                        <p>{{ $recording->year->year }}</p>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="classroom" class="font-medium form-label fs-16 text-label">Classe</label>
                        <p>{{ $recording->classroom->classroom }}</p>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="student" class="font-medium form-label fs-16 text-label">Élève</label>
                        <p>{{ $recording->student->name }} {{ $recording->student->surname }}</p>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="semester" class="font-medium form-label fs-16 text-label">Semestre</label>
                        <select class="form-select bg-form" name="semester" id="semester">
                            <option selected disabled class="text-secondary">Choisissez le semestre</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>

        <!-- Affichage des informations de l'élève et de la classe -->
        <div id="student-info" class="mt-4"></div>

        <!-- Tableau des notes et moyennes coefficientées -->
        <table class="table mt-3" id="notes-table">
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Note</th>
                    <th>Coefficient</th>
                    <th>Moyenne Coefficientée</th>
                    <th>Appréciation</th> <!-- Nouvelle colonne pour Appréciation -->
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="5" class="text-center">Sélectionnez un élève et un semestre pour afficher les notes</td>
                </tr>
            </tbody>
            <tfoot>
                <tr id="rang-row">
                    <th colspan="4" class="text-end">Rang :</th>
                    <th id="rang" class="text-end"></th>
                </tr>
                <tr>
                    <th colspan="4" class="text-end">Total :</th>
                    <th id="total-moyenne-coefficiee" class="text-end"></th>
                </tr>
                <tr>
                    <th colspan="4" class="text-end">Moyenne Générale :</th>
                    <th id="moyenne-generale" class="text-end"></th>
                </tr>
                <tr id="moyenne-annuelle-row" style="display: none;">
                    <th colspan="4" class="text-end">Moyenne Annuelle :</th>
                    <th id="moyenne-annuelle" class="text-end"></th>
                </tr>
            </tfoot>
        </table>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        // Fonction pour formater le rang avec les suffixes
        function formatRank(rank) {
            if (rank == 1) {
                return rank + 'er'; // 1er
            } else {
                return rank + 'ème'; // 2ème, 3ème, etc.
            }
        }

        // Charger les notes et les moyennes en fonction de l'élève et du semestre sélectionnés
        $('#semester').change(function () {
            let studentId = '{{ $recording->student->id }}';
            let semester = $('#semester').val();
            let yearId = '{{ $recording->year->id }}';
            let classroomId = '{{ $recording->classroom->id }}';

            if (studentId && semester) {
                $.ajax({
                    url: '{{ route("get.student.notes") }}',
                    type: 'GET',
                    data: {
                        student_id: studentId,
                        semester: semester,
                        year_id: yearId,
                        classroom_id: classroomId
                    },
                    success: function (data) {
                        $('#student-info').html(`
                            <p><strong>Élève :</strong> ${data.student_name}</p>
                            <p><strong>Classe :</strong> ${data.classroom}</p>
                            ${semester == 1 ? `<p><strong>Rang Semestriel :</strong> ${data.rank ? formatRank(data.rank) : 'N/A'}</p>` : ''}
                            ${semester == 2 ? `<p><strong>Rang Semestriel :</strong> ${data.rank ? formatRank(data.rank) : 'N/A'}</p>
                            <p><strong>Rang Annuel :</strong> ${data.rank_annuel ? formatRank(data.rank_annuel) : 'N/A'}</p>` : ''}
                        `);

                        let notesHtml = '';
                        let totalMoyenneCoefficiee = data.total_moyenne_coefficiee || 0;
                        let moyenneGenerale = data.moyenne_generale || 0;
                        let moyenneAnnuelle = data.moyenne_annuelle || 0;

                        if (data.notes.length) {
                            data.notes.forEach(function (note) {
                                // Calculer l'appréciation en fonction de la note
                                let appreciation = 'N/A';
                                    if (note.note < 5) {
                                        appreciation = 'Médiocre';
                                    } else if (note.note >= 5 && note.note < 10) {
                                        appreciation = 'Insuffisant';
                                    } else if (note.note >= 10 && note.note < 12) {
                                        appreciation = 'Passable';
                                    }else if (note.note >= 12 && note.note < 14) {
                                        appreciation = 'Assez Bien';
                                    }else if (note.note >= 14 && note.note < 16) {
                                        appreciation = 'Bien';
                                    }else if (note.note >= 16 && note.note < 19) {
                                        appreciation = 'Très Bien';
                                    }else  {
                                        appreciation = 'Honorable';
                                    }

                                notesHtml += `
                                    <tr>
                                        <td>${note.subject}</td>
                                        <td>${note.note}</td>
                                        <td>${note.coefficient}</td>
                                        <td>${note.moyenne_coefficiee}</td>
                                        <td>${appreciation}</td> <!-- Afficher l'appréciation -->
                                    </tr>
                                `;
                            });

                            $('#moyenne-annuelle-row').toggle(data.moyenne_annuelle !== undefined && semester == 2);
                            $('#rang-row').toggle(semester == 1 || semester == 2);
                            $('#total-moyenne-coefficiee').text(totalMoyenneCoefficiee.toFixed(2));
                            $('#moyenne-generale').text(moyenneGenerale.toFixed(2));
                            $('#moyenne-annuelle').text(moyenneAnnuelle.toFixed(2));
                        } else {
                            notesHtml = '<tr><td colspan="5" class="text-center">Aucune note disponible pour cet élève.</td></tr>';
                            $('#total-moyenne-coefficiee').text('0.00');
                            $('#moyenne-generale').text('0.00');
                            $('#moyenne-annuelle').text('0.00');
                            $('#moyenne-annuelle-row').hide();
                            $('#rang-row').hide();
                        }
                        $('#notes-table tbody').html(notesHtml);
                    },
                    error: function () {
                        alert('Erreur lors du chargement des notes. Veuillez réessayer.');
                    }
                });
            }
        });
    });
</script>

@endsection
