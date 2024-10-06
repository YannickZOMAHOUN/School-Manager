<?php $__env->startSection('another_CSS'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/datatable/dataTables.checkboxes.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/select2-bootstrap-5-theme.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Notes et Moyenne</h4>
    </div>
    <div class="card py-5">
        <form id="note-form">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-3 mb-3">
                        <label for="year" class="font-medium form-label fs-16 text-label">Année Scolaire</label>
                        <p><?php echo e($recording->year->year); ?></p>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <label for="classroom" class="font-medium form-label fs-16 text-label">Classe</label>
                        <p><?php echo e($recording->classroom->classroom); ?></p>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <label for="student" class="font-medium form-label fs-16 text-label">Élève</label>
                        <p><?php echo e($recording->student->name); ?> <?php echo e($recording->student->surname); ?></p>
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
            </div>
        </form>
        <div id="student-info" class="mt-4"></div>
        <!-- Tableau des notes et moyennes coefficientées -->
        <table class="table mt-3" id="notes-table">
            <thead>
                <tr>
                    <th>Matière</th>
                    <th>Coefficient</th>
                    <th>Note</th>
                    <th>Moyenne Coefficientée</th>
                    <th>Appréciation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="6" class="text-center">Sélectionnez un élève et un semestre pour afficher les notes</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-end">Total :</th>
                    <th id="total-moyenne-coefficiee" class="text-end"></th>
                    <th></th>
                </tr>
                <tr>
                    <th colspan="4" class="text-end">Moyenne Générale :</th>
                    <th id="moyenne-generale" class="text-end"></th>
                    <th></th>
                </tr>
                <tr id="moyenne-annuelle-row" style="display: none;">
                    <th colspan="4" class="text-end">Moyenne Annuelle :</th>
                    <th id="moyenne-annuelle" class="text-end"></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>

    </div>

    <!-- Modal de suppression générique -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        Êtes-vous sûr de vouloir supprimer cette note ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="<?php echo e(asset('js/jquery-3.6.0.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            // Fonction pour formater le rang avec les suffixes
            function formatRank(rank) {
                return rank === 1 ? rank + 'er' : rank + 'ème';
            }

            // Fonction pour afficher un message d'erreur
            function showError(message) {
                alert(message);
            }

            // Charger les notes et les moyennes en fonction de l'élève et du semestre sélectionnés
            $('#semester').change(function () {
                let studentId = '<?php echo e($recording->student->id); ?>';
                let semester = $('#semester').val();
                let yearId = '<?php echo e($recording->year->id); ?>';
                let classroomId = '<?php echo e($recording->classroom->id); ?>';

                if (studentId && semester) {
                    // Afficher un loader ou un message de chargement ici

                    $.ajax({
                        url: '<?php echo e(route("get.student.notes")); ?>',
                        type: 'GET',
                        data: {
                            student_id: studentId,
                            semester: semester,
                            year_id: yearId,
                            classroom_id: classroomId
                        },
                        success: function (data) {
                            $('#student-info').html(`
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
                                    let appreciation = 'N/A';
                                    if (note.note < 5) {
                                        appreciation = 'Médiocre';
                                    } else if (note.note >= 5 && note.note < 10) {
                                        appreciation = 'Insuffisant';
                                    } else if (note.note >= 10 && note.note < 12) {
                                        appreciation = 'Passable';
                                    } else if (note.note >= 12 && note.note < 14) {
                                        appreciation = 'Assez Bien';
                                    } else if (note.note >= 14 && note.note < 16) {
                                        appreciation = 'Bien';
                                    } else if (note.note >= 16 && note.note < 19) {
                                        appreciation = 'Très Bien';
                                    } else {
                                        appreciation = 'Honorable';
                                    }
                                    let editUrl = '<?php echo e(route("note.edit", ":id")); ?>';
                                    editUrl = editUrl.replace(':id', note.id);
                                    let deleteUrl = '<?php echo e(route("note.destroy", ":id")); ?>';
                                    deleteUrl = deleteUrl.replace(':id', note.id);

                                    notesHtml += `
                                        <tr>
                                            <td>${note.subject}</td>
                                            <td>${note.coefficient}</td>
                                            <td>${note.note}</td>
                                            <td>${note.moyenne_coefficiee}</td>
                                            <td>${appreciation}</td>
                                            <td>
                                                <a href="${editUrl}" class="btn btn-sm btn-primary">Modifier la note</a>
                                                <button type="button" class="btn btn-sm btn-danger delete-button" data-id="${note.id}">Supprimer</button>
                                            </td>
                                        </tr>
                                    `;
                                });

                                $('#moyenne-annuelle-row').toggle(data.moyenne_annuelle !== undefined && semester == 2);
                                $('#total-moyenne-coefficiee').text(totalMoyenneCoefficiee.toFixed(2));
                                $('#moyenne-generale').text(moyenneGenerale.toFixed(2));
                                $('#moyenne-annuelle').text(moyenneAnnuelle.toFixed(2));
                            } else {
                                notesHtml = '<tr><td colspan="6" class="text-center">Aucune note disponible pour cet élève.</td></tr>';
                                $('#total-moyenne-coefficiee').text('');
                                $('#moyenne-generale').text('');
                                $('#moyenne-annuelle').text('');
                            }

                            $('#notes-table tbody').html(notesHtml);
                        },
                        error: function (xhr, status, error) {
                            showError("Une erreur est survenue lors du chargement des notes. Veuillez réessayer.");
                        }
                    });
                }
            });

            // Suppression d'une note
            $(document).on('click', '.delete-button', function () {
                let noteId = $(this).data('id');
                $('#deleteForm').attr('action', `<?php echo e(url('notes')); ?>/${noteId}`);
                $('#deleteModal').modal('show');
            });

            // Réinitialiser le formulaire après la suppression
            $('#deleteForm').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function () {
                        $('#deleteModal').modal('hide');
                        // Rechargez les notes après suppression
                        $('#semester').change();
                    },
                    error: function () {
                        showError("Une erreur est survenue lors de la suppression de la note.");
                    }
                });
            });
        });
    </script>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/notes/show.blade.php ENDPATH**/ ?>