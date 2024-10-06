<?php $__env->startSection('another_CSS'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/datatable/dataTables.checkboxes.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/select2-bootstrap-5-theme.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Édition des coefficients</h4>
    </div>

    <div class="card py-5">
        <form action="<?php echo e(route('ratio.update',$ratio)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('put'); ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="classroom" class="font-medium form-label fs-16 text-label">
                            Classe
                        </label>
                        <select class="form-select bg-form" name="classroom" id="classroom"
                            aria-label="Sélectionnez une classe">
                            <option selected disabled class="text-secondary">Choisissez la classe</option>
                            <?php $__currentLoopData = $classrooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classroom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($classroom->id); ?>" <?php echo e($classroom->id == $ratio->classroom_id ? 'selected' :''); ?>><?php echo e($classroom->classroom); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="subject" class="font-medium form-label fs-16 text-label">
                            Matière
                        </label>
                        <select class="form-select bg-form" name="subject" id="subject"
                            aria-label="Sélectionnez une matière">
                            <option selected disabled class="text-secondary">Choisissez la matière</option>
                            <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($subject->id); ?>" <?php echo e($subject->id == $ratio->subject_id ? 'selected' :''); ?>><?php echo e($subject->subject); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-12 mb-3">
                        <label for="ratio" class="font-medium fs-16 text-black form-label">
                            Coefficient
                        </label>
                        <input type="number" step="0.1" name="ratio" id="ratio" class="form-control bg-form"
                            placeholder="Entrez le coefficient" aria-describedby="ratioHelp"  value="<?php echo e($ratio->ratio); ?>">
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/ratios/edit.blade.php ENDPATH**/ ?>