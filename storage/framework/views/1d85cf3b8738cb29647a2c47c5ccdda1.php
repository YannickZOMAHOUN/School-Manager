<?php $__env->startSection('content'); ?>
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Ajouter un nouvel utilisateur</h4>
    </div>

    <div class="card py-5">
        <form action="<?php echo e(route('staff.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <label for="role_id">Fonction:</label>
                    <select name="role_id" id="role_id" class="form-control" required>
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($role->id); ?>"><?php echo e($role->role_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label font-medium text-color-avt">Email</label>
                    <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label font-medium text-color-avt">Nom</label>
                    <input type="text" name="name" id="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="surname" class="form-label font-medium text-color-avt">Prénom(s)</label>
                    <input type="text" name="surname" id="surname" class="form-control <?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="number" class="form-label font-medium text-color-avt">Numéro de téléphone</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">+229</span>
                        </div>
                        <input type="tel" name="number" class="form-control <?php $__errorArgs = ['number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="number" required placeholder="Ex: 91000000" pattern="[0-9]{8}">
                    </div>
                    <?php $__errorArgs = ['number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="sex" class="form-label font-medium text-color-avt">Sexe</label>
                    <select name="sex" id="sex" class="form-control <?php $__errorArgs = ['sex'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                        <option value="M" <?php echo e(old('sex') == 'M' ? 'selected' : ''); ?>>Masculin</option>
                        <option value="F" <?php echo e(old('sex') == 'F' ? 'selected' : ''); ?>>Féminin</option>
                    </select>
                    <?php $__errorArgs = ['sex'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="user_password" class="form-label font-medium text-color-avt">Mot de Passe</label>
                    <input id="user_password" type="password" class="form-control <?php $__errorArgs = ['user_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="user_password" required autocomplete="new-password">
                    <?php $__errorArgs = ['user_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password-confirm" class="form-label">Confirmer votre mot de passe</label>
                    <input id="password-confirm" type="password" class="form-control <?php $__errorArgs = ['user_password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="user_password_confirmation" required>
                    <?php $__errorArgs = ['user_password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div id="password-error" style="color: red; display: none;">Les mots de passe ne correspondent pas.</div>
            <div class="row d-flex justify-content-center mt-2">
                <button type="reset" class="btn bg-secondary w-auto me-2 text-white">Annuler</button>
                <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const password = document.getElementById('user_password');
        const passwordConfirm = document.getElementById('password-confirm');
        const passwordError = document.getElementById('password-error');
        const form = document.querySelector('form');

        // Fonction pour vérifier si les mots de passe correspondent
        function checkPasswords() {
            const passwordsMatch = password.value === passwordConfirm.value;
            passwordError.style.display = passwordsMatch ? 'none' : 'block';
            passwordConfirm.setCustomValidity(passwordsMatch ? '' : "Les mots de passe ne correspondent pas");
        }

        // Vérification à la frappe dans le champ de confirmation
        passwordConfirm.addEventListener('input', checkPasswords);

        // Vérification lors de la soumission du formulaire
        form.addEventListener('submit', function(event) {
            checkPasswords(); // Assurez-vous que la vérification a été effectuée
            if (!passwordConfirm.checkValidity()) {
                event.preventDefault(); // Empêche l'envoi si les mots de passe ne correspondent pas
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/staff/create.blade.php ENDPATH**/ ?>