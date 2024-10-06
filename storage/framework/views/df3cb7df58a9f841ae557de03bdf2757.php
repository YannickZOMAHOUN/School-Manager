<?php $__env->startSection('content'); ?>
    <form method="POST" action="<?php echo e(route('two_fa.verify.post')); ?>">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label for="two_fa_code" class="form-label">Code de vérification</label>
            <input type="text" name="two_fa_code" class="form-control" required>

            <?php if($errors->has('two_fa_code')): ?>
                <span class="text-danger"><?php echo e($errors->first('two_fa_code')); ?></span>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Vérifier</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.authentification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/auth/two_factor_verify.blade.php ENDPATH**/ ?>