<?php $__env->startSection('another_CSS'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/datatable/dataTables.checkboxes.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/select2-bootstrap-5-theme.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Modifier une note</h4>
    </div>
    <div class="card py-5">
        <form id="note-form" action="<?php echo e(route('note.update', $note->id)); ?>" method="POST"  enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-4 mb-3">
                        <label for="year_id">Année scolaire:</label>
                        <select name="year_id" id="year_id" class="form-control" required>
                            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($year->id); ?>" <?php echo e($year->id == old('year_id', $note->recording->first()->year_id) ? 'selected' : ''); ?>>
                                    <?php echo e($year->year); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="classroom">Classe:</label>
                        <select class="form-select bg-form" name="classroom_id" id="classroom_id" aria-label="Default select example">
                            <?php $__currentLoopData = $classrooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classroom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($classroom->id); ?>" <?php echo e($classroom->id == old('classroom_id', $note->recording->first()->classroom_id) ? 'selected' : ''); ?>>
                                    <?php echo e($classroom->classroom); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-4 mb-3">
                        <label for="student" class="font-medium form-label fs-16 text-label">Élève</label>

                       <input type="text"  name="student" id="student" class="form-control bg-form" placeholder="" value="<?php echo e($note->recording->student->name); ?> <?php echo e($note->recording->student->surname); ?>">
                    </div>
                </div>
                <div class="row">

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
                        <label for="ratio" class="font-medium form-label fs-16 text-label">Coefficient</label>
                        <input type="number" name="ratio" id="ratio" class="form-control bg-form" readonly>
                        <input type="hidden" name="ratio_id" id="ratio_id"> <!-- Champ caché pour ratio_id -->
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <label for="semester" class="font-medium form-label fs-16 text-label">Semestre</label>
                        <select class="form-select bg-form" name="semester" id="semester">
                            <option selected disabled class="text-secondary">Choisissez le semestre</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 mb-3">
                        <label for="note" class="font-medium fs-16 text-black form-label">Moyenne non coefficiée</label>
                        <input type="number" step="any" name="note" id="note" class="form-control bg-form" placeholder="Entrez la note" value="<?php echo e($note->note); ?>">
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

<script src="<?php echo e(asset('js/jquery-3.6.0.min.js')); ?>"></script>
<!-- Bootstrap JS (v5) -->
<script src="<?php echo e(asset('js/bootstrap.bundle.min.js')); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        // Charger les élèves automatiquement
        $('#year, #classroom').change(function () {
            let yearId = $('#year').val();
            let classroomId = $('#classroom').val();
            if (yearId && classroomId) {
                $.ajax({
                    url: '<?php echo e(route("get.students")); ?>',
                    type: 'GET',
                    data: {year_id: yearId, classroom_id: classroomId},
                    success: function (data) {
                        $('#student').empty().append('<option selected disabled>Sélectionnez l\'élève</option>');
                        data.forEach(function (student) {
                            $('#student').append(`<option value="${student.id}">${student.name} ${student.surname}</option>`);
                        });
                    },
                    error: function () {
                        toastr.error('Une erreur est survenue lors du chargement des élèves.', 'Erreur', {
                            timeOut: 5000,
                            progressBar: true
                        });
                    }
                });
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/notes/edit.blade.php ENDPATH**/ ?>