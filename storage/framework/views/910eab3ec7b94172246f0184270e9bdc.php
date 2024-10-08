<?php $__env->startSection('another_CSS'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/datatable/dataTables.checkboxes.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/select2-bootstrap-5-theme.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row col-12  pb-5">
        <div class="my-3">
            <h4 class="font-medium  text-color-avt">Enregistrement d'une nouvelle classe </option>
            </h4>
        </div>

        <div class="card py-5">
            <form action="<?php echo e(route('classroom.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 mb-3">
                                <label for="classroom" class="font-medium fs-16 text-black form-label ">Classe
                                </label>
                                <input type="text" name="classroom" id="classroom" class="form-control bg-form " placeholder="">
                         </div>

                            <div class="row d-flex justify-content-center mt-2">

                                <button type="reset" class="btn bg-secondary w-auto me-2 text-white">Annuler</button>
                                <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
         </div>

 </div>

 <div class="d-flex justify-content-between my-2 flex-wrap">
        <div class="text-color-avt fs-22">Liste des classes
        </div>
    </div>

    <div class="card p-3">
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>

                <tr class="text-center">
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
               <?php $__currentLoopData = $classrooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$classroom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <?php if($classroom->school_id == auth()->user()->school->id): ?>
                    <tr>
                        <td><?php echo e($classroom->classroom); ?></td>
                        <td class="text-center" style="cursor: pointer">
                            <a class="text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="top" title="Editer la classe" href="<?php echo e(route('classroom.edit', $classroom)); ?>"> <i class="fas fa-pen"></i> </a>
                            &nbsp;
                            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Supprimer cette classe " class="">
                                    <i data-bs-toggle="modal" data-bs-target="#delete_classroom<?php echo e($classroom->id); ?>" class="fas fa-trash-alt text-danger" ></i>
                            </a>
                        </td>
                    </tr>
                    <div class="modal fade" id="delete_classroom<?php echo e($classroom->id); ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-color-avt">Confirmer suppression de la classe <?php echo e($classroom->classroom); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action=" <?php echo e(route('classroom.destroy',$classroom)); ?> " method="POST">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('delete'); ?>
                                                <div class="d-flex justify-content-center">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-danger ms-2">Confirmer </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
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
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/classrooms/create.blade.php ENDPATH**/ ?>