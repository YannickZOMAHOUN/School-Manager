<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('school.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>

    <div class="mb-3">
        <label for="school" class="form-label font-medium text-color-avt">Nom de l'établissement</label>
        <input type="text" class="form-control rounded-pill py-2" id="school" name="school" value="<?php echo e(old('school')); ?>" required>
        <?php if($errors->has('school')): ?>
            <span class="text-danger"><?php echo e($errors->first('school')); ?></span>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="role_name" class="form-label font-medium text-color-avt">Fonctions disponibles</label>
        <input type="text" class="form-control rounded-pill py-2" id="role_name" name="role_name" value="<?php echo e(old('role_name')); ?>" placeholder="Exemple : Directeur; Enseignant; Surveillant" required>
        <?php if($errors->has('role_name')): ?>
            <span class="text-danger"><?php echo e($errors->first('role_name')); ?></span>
        <?php endif; ?>
    </div>

    <div class="py-2 mb-3">
        <button type="submit" class="btn btn-avt-2 d-block w-100 py-2 rounded-pill">Créer l'établissement</button>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.authentification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/schools/create.blade.php ENDPATH**/ ?>