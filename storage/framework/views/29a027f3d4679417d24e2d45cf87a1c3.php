
<div>
    <h4 class="font-medium text-color-avt">Ajouter les notes</h4>

    <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div class="alert alert-success">
            <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    <form wire:submit.prevent="saveNote">
        <div class="row">
            <div class="col-12 col-md-4 mb-3">
                <label for="year" class="font-medium form-label fs-16 text-label">Année Scolaire</label>
                <select wire:model="year_id" class="form-select bg-form">
                    <option selected disabled>Choisissez l'année scolaire</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($year->id); ?>"><?php echo e($year->year); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="classroom" class="font-medium form-label fs-16 text-label">Classe</label>
                <select wire:model="classroom_id" class="form-select bg-form">
                    <option selected disabled>Choisissez la classe</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $classrooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classroom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($classroom->id); ?>"><?php echo e($classroom->classroom); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="student" class="font-medium form-label fs-16 text-label">Élève</label>
                <select wire:model="student_id" class="form-select bg-form">
                    <option selected disabled>Sélectionnez l'élève</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($student->id); ?>"><?php echo e($student->name); ?> <?php echo e($student->surname); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-4 mb-3">
                <label for="subject" class="font-medium form-label fs-16 text-label">Matière</label>
                <select wire:model="subject_id" class="form-select bg-form">
                    <option selected disabled>Sélectionnez la matière</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->subject); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="ratio" class="font-medium form-label fs-16 text-label">Coefficient</label>
                <input wire:model="ratio_id" type="number" class="form-control bg-form" readonly>
            </div>

            <div class="col-12 col-md-4 mb-3">
                <label for="semester" class="font-medium form-label fs-16 text-label">Semestre</label>
                <select class="form-select bg-form" wire:model="semester" id="semester">
                    <option selected disabled class="text-secondary">Choisissez le semestre</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
        </div>

        <div class="col-12 col-md-12 mb-3">
            <label for="note" class="font-medium fs-16 text-black form-label">Moyenne non coefficiée</label>
            <input wire:model="note" type="number" step="0.1" class="form-control bg-form" placeholder="Entrez la note">
        </div>

        <div class="row d-flex justify-content-center mt-2">
            <button type="submit" class="btn btn-success w-auto">Enregistrer</button>
        </div>
    </form>
</div>
<?php /**PATH C:\laragon\www\School-Manager\resources\views/livewire/manage-student-notes.blade.php ENDPATH**/ ?>