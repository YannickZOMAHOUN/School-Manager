<?php $__env->startSection('content'); ?>
<h2>Bonjour, M./Mme <?php echo e($name); ?> <?php echo e($surname); ?></h2>
<p style='font-size:1.1em;'>
    Voici votre code pour valider la connexion à votre compte SCHOOL MANAGER <br>
     <b style='color:red;'> &#x26A0; Attention, le code a une validité de 10 minutes </b>
</p>
 <p style='margin-top:30px;margin-bottom:30px;'></p>
<p style='width:45%;margin:auto;padding:15px;background-color:#2962E6; color:#fff;border-radius:5px;text-align:center'>
<b style='font-size:1.8em;font-weight:500;'><?php echo e($code); ?></b> </p>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('emails.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/emails/two_factor_code.blade.php ENDPATH**/ ?>