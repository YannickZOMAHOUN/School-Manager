<?php $__env->startSection('another_CSS'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/datatable/dataTables.checkboxes.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/select2-bootstrap-5-theme.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row col-12  pb-5">
    <div class="my-3">
        <h5 class="text-color-avt px-0">Modification</h5>
        <div class="d-flex justify-content-between flex-wrap mb-2 px-0">
            <a class="btn btn-secondary btn-style" href="<?php echo e(route('classroom.create')); ?>"><i
                    class="fas fa-chevron-left"></i>Liste des classes</a>
        </div>
    </div>

        <div class="card py-5">
            <form action="<?php echo e(route('classroom.update',$classroom)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('put'); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 mb-3">
                                <label for="classroom" class="font-medium fs-16 text-black form-label ">Classe
                                </label>
                                <input type="text" name="classroom" id="classroom" class="form-control bg-form " placeholder="" value="<?php echo e($classroom->classroom); ?>">
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

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/dashboard/classrooms/edit.blade.php ENDPATH**/ ?>