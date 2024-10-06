<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>School Manager</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Include CSS files -->
  <?php echo $__env->make("layouts.css", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!-- Additional CSS -->
  <?php echo $__env->yieldContent("another_CSS"); ?>

  <style>
    #spinner {
      position: fixed;
      left: 0;
      right: 0;
      top: 0;
      bottom: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: rgba(0, 0, 0, 0.25);
      z-index: 20000;
    }
  </style>
</head>

<body>
  <main>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card">
            <div class="card-header text-center"><?php echo e(__('Créez votre profil')); ?></div>
            <div class="card-body">

              <!-- Display success message -->
              <?php if(session('success')): ?>
              <div class="alert alert-success">
                <?php echo e(session('success')); ?>

              </div>
              <?php endif; ?>

              <form method="POST" action="<?php echo e(route('register')); ?>" novalidate>
                <?php echo csrf_field(); ?>
                <h1><?php echo e($school_name); ?></h1>
                <input type="hidden" id="school_id" name="school_id" value="<?php echo e(old('school_id', $school_id ?? '')); ?>">

                <!-- Selection de la fonction (rôle) -->
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="role_id" class="form-label">Fonction :</label>
                    <select name="role_id" id="role_id" class="form-control" required>
                      <option value="">Sélectionnez une fonction</option>
                    </select>
                  </div>

                  <!-- Sélection du sexe -->
                  <div class="col-md-6">
                    <label for="sex" class="form-label">Sexe :</label>
                    <select name="sex" id="sex" class="form-control " required>
                      <option value="M" <?php echo e(old('sex') == 'M' ? 'selected' : ''); ?>>Masculin</option>
                      <option value="F" <?php echo e(old('sex') == 'F' ? 'selected' : ''); ?>>Féminin</option>
                    </select>
                    <?php $__errorArgs = ['sex'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                </div>

                <!-- Nom et prénom -->
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="name" class="form-label">Nom :</label>
                    <input id="name" type="text" class="form-control  <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name')); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                  <div class="col-md-6">
                    <label for="surname" class="form-label">Prénom :</label>
                    <input type="text" name="surname" class="form-control  <?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="surname" value="<?php echo e(old('surname')); ?>" required>
                    <?php $__errorArgs = ['surname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                </div>

                <!-- Email et numéro de téléphone -->
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="email" class="form-label">Email :</label>
                    <input type="email" name="email" class="form-control  <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" value="<?php echo e(old('email')); ?>" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                  <div class="col-md-6">
                    <label for="number" class="form-label">Numéro de téléphone :</label>
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
unset($__errorArgs, $__bag); ?>" id="number" value="<?php echo e(old('number')); ?>" required pattern="[0-9]{8}" placeholder="Ex: 91000000">
                    </div>
                    <?php $__errorArgs = ['number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                </div>

                <!-- Mot de passe et confirmation -->
                <div class="row mb-3">
                  <div class="col-md-6">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input id="password" type="password" class="form-control  <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" required>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                  </div>
                  <div class="col-md-6">
                    <label for="password-confirm" class="form-label">Confirmation du mot de passe :</label>
                    <input id="password-confirm" type="password" class="form-control " name="password_confirmation" required>
                  </div>
                </div>

                <!-- Bouton d'inscription -->
                <div class="row mb-0">
                  <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary rounded-pill">S'inscrire</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Include JS files -->
  <?php echo $__env->make("layouts.js", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <!-- AJAX script for loading roles -->
  <script src="<?php echo e(asset('js/jquery-3.6.0.min.js')); ?>"></script>
  <script>
    $(document).ready(function() {
      var schoolId = $('#school_id').val(); // Obtenir l'ID de l'école du champ hidden
      if (schoolId) {
        loadRoles(schoolId); // Charger les rôles automatiquement
      }

      function loadRoles(schoolId) {
        var roleSelect = $('#role_id');
        roleSelect.prop('disabled', true).empty().append('<option value="">Chargement des rôles...</option>');

        $.ajax({
          url: '<?php echo e(route('getRoles')); ?>',
          method: 'GET',
          data: { school_id: schoolId },
          success: function(data) {
            roleSelect.empty().prop('disabled', false);
            $.each(data.roles, function(index, role) {
              roleSelect.append('<option value="' + role.id + '">' + role.role_name + '</option>');
            });
          },
          error: function() {
            roleSelect.empty().append('<option value="">Erreur lors du chargement des rôles</option>');
          }
        });
      }
    });
  </script>

  <!-- Script to validate password confirmation -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const password = document.getElementById('password');
      const passwordConfirm = document.getElementById('password-confirm');

      function checkPasswords() {
        const match = password.value === passwordConfirm.value;
        passwordConfirm.setCustomValidity(match ? '' : 'Les mots de passe ne correspondent pas');
      }

      passwordConfirm.addEventListener('input', checkPasswords);
    });
  </script>
</body>

</html>
<?php /**PATH C:\laragon\www\School-Manager\resources\views/auth/register.blade.php ENDPATH**/ ?>