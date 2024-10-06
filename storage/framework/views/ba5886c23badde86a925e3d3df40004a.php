<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('login')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="mb-3">
        <label for="email" class="form-label font-medium text-color-avt">Email</label>
        <input type="email" class="form-control rounded-pill py-2" name="email" value="<?php echo e(old('email')); ?>" required>

        <?php if($errors->has('email')): ?>
        <span class="text-danger fs-12"><?php echo e($errors->first('email')); ?></span>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label font-medium text-color-avt">Mot de passe</label>
        <input type="password" class="form-control rounded-pill py-2" name="password" required>

        <?php if($errors->has('password')): ?>
        <span class="text-danger fs-12"><?php echo e($errors->first('password')); ?></span>
        <?php endif; ?>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="remember" name="remember">
        <label class="form-check-label" for="remember">
            <?php echo e(__('Se souvenir de moi')); ?>

        </label>
    </div>
    <div class="py-2 mb-3">
        <button type="submit" class="btn btn-avt-2 d-block w-100 py-2 rounded-pill"> <?php echo e(__('Se connecter')); ?> </button>
    </div>
</form>

<div class="text-center">
    <a href="<?php echo e(route('school.create')); ?>" class="text-color-avt">
        <?php echo e(__('Créer une école')); ?>

    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.authentification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/auth/login.blade.php ENDPATH**/ ?>