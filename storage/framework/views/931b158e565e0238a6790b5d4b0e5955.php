<?php $__env->startSection("another_CSS"); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/datatable/bootstrap.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/datatable/dataTables.bootstrap4.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>

<div class="d-flex justify-content-between my-2 flex-wrap">
    <div class="text-color-avt fs-22 font-medium">Note(s) des élèves</div>
</div>

<!-- Formulaire de sélection de la classe et de l'année scolaire -->
<form method="GET" action="<?php echo e(route('note.index')); ?>" class="mb-4" id="filterForm">
    <div class="row">
        <div class="col-12 col-md-3 mb-3">
            <label for="year" class="font-medium form-label fs-16 text-label">
                Année Scolaire
            </label>
            <select class="form-select bg-form" name="year" id="year" aria-label="Sélectionnez l'année scolaire">
                <option selected disabled class="text-secondary">Choisissez l'année scolaire</option>
                <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($year->id); ?>"><?php echo e($year->year); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-12 col-md-3 mb-3">
            <label for="classroom" class="font-medium form-label fs-16 text-label">
                Classe
            </label>
            <select class="form-select bg-form" name="classroom" id="classroom" aria-label="Sélectionnez une classe">
                <option selected disabled class="text-secondary">Choisissez la classe</option>
                <?php $__currentLoopData = $classrooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classroom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($classroom->id); ?>"><?php echo e($classroom->classroom); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="col-12 col-md-3 mb-3">
            <label for="subject" class="font-medium form-label fs-16 text-label">Matière</label>
            <select class="form-select bg-form" name="subject" id="subject" aria-label="Sélectionnez une matière">
                <option selected disabled class="text-secondary">Sélectionnez la matière</option>
                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->subject); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <th>Moyenne Non Coefficié</th>
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
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
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

<script src="<?php echo e(asset('js/jquery-3.6.0.min.js')); ?>"></script>
<!-- Bootstrap JS (v5) -->
<script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>

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
            fetch(`<?php echo e(route('notes.load')); ?>?classroom=${classroom}&year=${year}&subject=${subject}&semester=${semester}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const tbody = document.querySelector('#students tbody');
                    tbody.innerHTML = '';

                    data.forEach(note => {
                        let editUrl = '<?php echo e(route("note.edit", ":id")); ?>';
                            editUrl = editUrl.replace(':id', note.id);
                            let deleteUrl = '<?php echo e(route("note.destroy", ":id")); ?>';
                            deleteUrl = deleteUrl.replace(':id', note.id);
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${note.recording.student.name}</td>
                            <td>${note.recording.student.surname}</td>
                            <td>${note.note}</td>
                            <td>
                                        <a href="${editUrl}" class="btn btn-sm btn-primary">Modifier la note</a>
                                        <button type="button" class="btn btn-sm btn-danger delete-button" data-id="${note.id}">Supprimer</button>
                                    </td>
                        `;
                        tbody.appendChild(tr);
                    });
                });
                 // Remplir le modal de suppression avec l'ID de la note
    $(document).on('click', '.delete-button', function () {
        var noteId = $(this).data('id');
        var deleteUrl = '<?php echo e(route("note.destroy", ":id")); ?>';
        deleteUrl = deleteUrl.replace(':id', noteId);

        $('#deleteForm').attr('action', deleteUrl);
        $('#deleteModal').modal('show');
    });
        }
    }
});
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/notes/list.blade.php ENDPATH**/ ?>