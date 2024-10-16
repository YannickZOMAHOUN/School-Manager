<?php $__env->startSection('another_CSS'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/datatable/dataTables.checkboxes.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/select2-bootstrap-5-theme.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Impression des bulletins et Classement</h4>
    </div>
    <div class="card py-5">
        <form action="<?php echo e(route('bulletins.generate')); ?>" method="POST" target="_blank" id="bulletins-form">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <div class="row">
                    <input type="hidden" name="year_id" id="year_id">
                    <input type="hidden" name="classroom_id" id="classroom_id">
                    <input type="hidden" name="semester_hidden" id="semester_hidden">

                    <div class="col-12 col-md-4 mb-3">
                        <label for="year" class="font-medium form-label fs-16 text-label">Année Scolaire</label>
                        <select class="form-select bg-form" name="year" id="year" aria-label="Sélectionnez l'année scolaire" required>
                            <option selected disabled class="text-secondary">Choisissez l'année scolaire</option>
                            <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($year->id); ?>"><?php echo e($year->year); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-12 col-md-4 mb-3">
                        <label for="classroom" class="font-medium form-label fs-16 text-label">Classe</label>
                        <select class="form-select bg-form" name="classroom" id="classroom" aria-label="Sélectionnez une classe" required>
                            <option selected disabled class="text-secondary">Choisissez la classe</option>
                            <?php $__currentLoopData = $classrooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classroom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($classroom->id); ?>"><?php echo e($classroom->classroom); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <!-- Bouton pour imprimer le classement -->
                <button type="button" class="btn btn-primary fs-14" id="print-ranking">
                    <i class="bi bi-printer"></i> Imprimer Classement
                </button>

                <!-- Bouton pour imprimer les bulletins -->
                <button type="submit" class="btn btn-success fs-14" id="print-card">
                    <i class="bi bi-printer"></i> Imprimer Bulletins
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Remplir les champs cachés avec les valeurs sélectionnées
    document.getElementById('year').addEventListener('change', function() {
        document.getElementById('year_id').value = this.value;
    });

    document.getElementById('classroom').addEventListener('change', function() {
        document.getElementById('classroom_id').value = this.value;
    });

    document.getElementById('semester').addEventListener('change', function() {
        document.getElementById('semester_hidden').value = this.value;
    });

    // Fonction pour réinitialiser le formulaire
    function resetForm() {
        document.getElementById('year').selectedIndex = 0;
        document.getElementById('classroom').selectedIndex = 0;
        document.getElementById('semester').selectedIndex = 0;
        document.getElementById('year_id').value = '';
        document.getElementById('classroom_id').value = '';
        document.getElementById('semester_hidden').value = '';
    }

    // Générer le classement et ouvrir dans une nouvelle fenêtre
    document.getElementById('print-ranking').addEventListener('click', function() {
        var form = document.querySelector('#bulletins-form');
        form.action = "<?php echo e(route('ranking.generate')); ?>";
        form.target = "_blank";
        form.submit();
        // resetForm(); // Décommentez si vous souhaitez réinitialiser le formulaire après l'impression
    });

    document.getElementById('print-card').addEventListener('click', function() {
        var form = document.querySelector('#bulletins-form');
        form.action = "<?php echo e(route('bulletins.generate')); ?>";
        form.target = "_blank";
        form.submit();
        // resetForm(); // Décommentez si vous souhaitez réinitialiser le formulaire après l'impression
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/notes/card.blade.php ENDPATH**/ ?>