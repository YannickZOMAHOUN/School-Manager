<?php $__env->startSection('content'); ?>
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Modifier les informations de l'élève</h4>
    </div>

    <div class="card py-5">
        <form action="<?php echo e(route('student.update', $student->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PATCH'); ?>
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="classroom">Classe:</label>
                    <select class="form-select bg-form" name="classroom_id" id="classroom_id" aria-label="Default select example">
                        <?php $__currentLoopData = $classrooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classroom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($classroom->id); ?>" <?php echo e($classroom->id == old('classroom_id', $student->recordings->first()->classroom_id) ? 'selected' : ''); ?>>
                                <?php echo e($classroom->classroom); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="year_id">Année scolaire:</label>
                    <select name="year_id" id="year_id" class="form-control" required>
                        <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($year->id); ?>" <?php echo e($year->id == old('year_id', $student->recordings->first()->year_id) ? 'selected' : ''); ?>>
                                <?php echo e($year->year); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="matricule">Matricule</label>
                    <input type="text" name="matricule" id="matricule" class="form-control bg-form" value="<?php echo e(old('matricule', $student->matricule)); ?>">
                </div>
                <div class="col-md-6">
                    <label for="sex" class="form-label font-medium text-color-avt">Sexe</label>
                    <select name="sex" id="sex" class="form-control" required>
                        <option value="M" <?php echo e(old('sex', $student->sex) == 'M' ? 'selected' : ''); ?>>Masculin</option>
                        <option value="F" <?php echo e(old('sex', $student->sex) == 'F' ? 'selected' : ''); ?>>Féminin</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="name" class="form-label font-medium text-color-avt">Nom de l'élève</label>
                    <input type="text" name="name" id="name" class="form-control bg-form" value="<?php echo e(old('name', $student->name)); ?>">
                </div>
                <div class="col-md-6">
                    <label for="surname" class="form-label font-medium text-color-avt">Prénom</label>
                    <input type="text" name="surname" id="surname" class="form-control bg-form" value="<?php echo e(old('surname', $student->surname)); ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="birthday" class="form-label font-medium text-color-avt">Date de Naissance</label>
                    <input type="date" name="birthday" id="birthday" class="form-control bg-form" value="<?php echo e(old('birthday', $student->birthday)); ?>">
                </div>
                <div class="col-md-6">
                    <label for="birthplace" class="form-label font-medium text-color-avt">Lieu de Naissance</label>
                    <input type="text" name="birthplace" id="birthplace" class="form-control bg-form" value="<?php echo e(old('birthplace', $student->birthplace)); ?>">
                </div>
            </div>

            <div class="row d-flex justify-content-center mt-2">
                <button type="reset" class="btn bg-secondary w-auto me-2 text-white">Annuler</button>
                <button type="submit" class="btn btn-success w-auto">Modifier</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/students/edit.blade.php ENDPATH**/ ?>