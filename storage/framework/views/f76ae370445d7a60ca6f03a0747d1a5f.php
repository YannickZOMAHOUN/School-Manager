<?php $__env->startSection("another_CSS"); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/datatable/bootstrap.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/datatable/dataTables.bootstrap4.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection("content"); ?>

    <div class="d-flex justify-content-between my-2 flex-wrap">
        <div class="text-color-avt fs-22 font-medium">Liste des membres <?php echo e(auth()->user()->school->school); ?></div>
        <div>
            <a class="btn btn-success fs-14" href="<?php echo e(route('staff.create')); ?>">
                <i class="fas fa-plus"></i> Ajouter un membre
            </a>
        </div>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr class="text-center">
                    <th>Fonction</th>
                    <th>Nom</th>
                    <th>Prénom(s)</th>
                    <th>Sexe</th>
                    <th>Email</th>
                    <th>Numéro de téléphone</th>
                    <th>Actions </th>
                </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($member->role->role_name); ?></td>
                        <td><?php echo e($member->name); ?></td>
                        <td><?php echo e($member->surname); ?></td>
                        <td><?php if($member->sex == 'M'): ?>
                            Masculin
                        <?php elseif($member->sex == 'F'): ?>
                            Féminin
                        <?php else: ?>
                            Non spécifié
                        <?php endif; ?></td>
                        <td><?php echo e($member->user->email); ?></td>
                        <td><?php echo e($member->number); ?></td>
                        <td class="text-center" style="cursor: pointer">
                            <a class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Éditer des informations" href="<?php echo e(route('staff.edit', $member)); ?>">
                                <i class="fas fa-pen"></i>
                            </a>
                            &nbsp;
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer">
                                <i data-bs-toggle="modal" data-bs-target="#deleteModal" class="fas fa-trash-alt text-danger delete-staff" data-staff-id="<?php echo e($member->id); ?>"></i>
                            </a>
                        </td>
                    </tr>
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
            $('#example').DataTable(
                {
                    "language": {
                        "url": "<?php echo e(asset('js/datatable/French.json')); ?>"
                    },
                    responsive: true,
                    "columnDefs": [ {
                        "targets": -1,
                        "orderable": false
                    } ]
                }
            );
            $('.alert').alert('close')


        // Définir l'URL de suppression dynamique pour le modal
        $(document).on('click', '.delete-staff', function() {
            let staffId = $(this).data('staff-id');
            let url = "<?php echo e(route('staff.destroy', ':id')); ?>";
            url = url.replace(':id', staffId);
            $('#deleteForm').attr('action', url);
        });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/staff/list.blade.php ENDPATH**/ ?>