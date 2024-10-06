<?php $__env->startSection('content'); ?>
<section class="section dashboard">
     <div class="row col-12">

          <div class="col-6 col-md-3">
            <div class="card info-card customers-card home-card-height">
              <div class="card-body p-2">
               <h5 class="card-title text-dark">Classe</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-folder-open"> </i>
                  </div>
                  <div class="ps-3">
                  <h6><?php echo e($classrooms); ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-6 col-md-3">
            <div class="card info-card customers-card home-card-height">
              <div class="card-body p-2">
               <h5 class="card-title text-dark">Elèves</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-folder-open"> </i>
                  </div>
                  <div class="ps-3">
                  <h6>`<?php echo e($students); ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-6 col-md-3">
            <div class="card info-card customers-card home-card-height">
              <div class="card-body p-2">
               <h5 class="card-title text-dark">Administration</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-folder-open"> </i>
                  </div>
                  <div class="ps-3">
                  <h6><?php echo e($staff); ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="card info-card customers-card home-card-height">
              <div class="card-body p-2">
               <h5 class="card-title text-dark">Matières</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fas fa-folder-open"> </i>
                  </div>
                  <div class="ps-3">
                  <h6><?php echo e($subjects); ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\School-Manager\resources\views/accueil.blade.php ENDPATH**/ ?>