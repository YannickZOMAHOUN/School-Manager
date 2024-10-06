<?php $__env->startSection('another_CSS'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/datatable/dataTables.checkboxes.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/select2-bootstrap-5-theme.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row col-12 pb-5">
    <div class="my-3">
        <h4 class="font-medium text-color-avt">Enregistrement d'une nouvelle matière</h4>
    </div>

    <div class="card py-5">
        <form action="<?php echo e(route('subject.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 mb-3">
                        <label for="subject" class="font-medium fs-16 text-black form-label">Matière</label>
                        <input type="text" name="subject" id="subject" class="form-control bg-form <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('subject')); ?>">
                        <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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

<div class="d-flex justify-content-between my-2 flex-wrap">
    <div class="text-color-avt fs-22">Matières de l'école <?php echo e(auth()->user()->school->school); ?></div>
</div>

<div class="card p-3">
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>Matière</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($subject->school_id == auth()->user()->school->id): ?>  
                <tr>
                    <td><?php echo e($subject->subject); ?></td>
                    <td class="text-center">
                        <a class="text-decoration-none text-secondary" data-bs-toggle="tooltip" title="Détails" href="<?php echo e(route('subject.show', $subject)); ?>">
                            <i class="bi bi-printer"></i>
                        </a>
                        &nbsp;
                        <a class="text-decoration-none" data-bs-toggle="tooltip" title="Éditer" href="<?php echo e(route('subject.edit', $subject)); ?>">
                            <i class="fas fa-pen"></i>
                        </a>
                        &nbsp;
                        <i data-subject-id="<?php echo e($subject->id); ?>" data-bs-toggle="modal" data-bs-target="#deleteModal" class="fas fa-trash-alt text-danger delete-subject"></i>
                    </td>
                </tr>
                <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>

<?php echo $__env->make('modals.delete', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>  
<?php $__env->stopSection(); ?>

<?php $__env->startSection("another_Js"); ?>

<script src="<?php echo e(asset('js/datatable/jquery-3.5.1.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatable/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/datatable/dataTables.bootstrap4.min.js')); ?>"></script>

<script>
    $(document).ready(function(){
        $('#example').DataTable({
            "language": {
                "url": "<?php echo e(asset('js/datatable/French.json')); ?>"
            },
            responsive: true,
            "columnDefs": [{
                "targets": -1,
                "orderable": false
            }]
        });

        // Définir l'URL de suppression dynamique pour le modal
        $(document).on('click', '.delete-subject', function() {
            let subjectId = $(this).data('subject-id');
            let url = "<?php echo e(route('subject.destroy', ':id')); ?>";
            url = url.replace(':id', subjectId);
            $('#deleteForm').attr('action', url);
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/subjects/create.blade.php ENDPATH**/ ?>