<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link text-decoration-none" href="<?php echo e(route('dashboard.index')); ?>">
          <i class="fas fa-home"></i>
          <span>&nbsp; Accueil</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#notes-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-calculator-fill"></i><span>&nbsp;Les Notes</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="notes-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo e(route('note.index')); ?>" class="text-decoration-none">
              <i class="fas fa-list"></i><span>&nbsp;Voir les notes</span>
            </a>
          </li>
          <li>
            <a href="<?php echo e(route('note.create')); ?>" class="text-decoration-none">
              <i class="fas fa-plus"></i><span>&nbsp;Nouvelle Note</span>
            </a>
          </li>
          <li>
            <a href="<?php echo e(route('get.cards')); ?>" class="text-decoration-none">
              <i class="fas fa-list"></i><span>&nbsp;Bulletins</span>
            </a>
          </li>
        </ul>
      </li><!-- End Notes Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#students-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-briefcase-fill"></i><span>&nbsp;Elèves</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="students-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo e(route('student.index')); ?>" class="text-decoration-none">
              <i class="fas fa-list"></i><span>&nbsp;Liste des élèves</span>
            </a>
          </li>
          <li>
            <a href="<?php echo e(route('student.create')); ?>" class="text-decoration-none">
              <i class="fas fa-plus"></i><span>&nbsp;Nouvel Elève</span>
            </a>
          </li>
        </ul>
      </li><!-- End Students Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#staff-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-briefcase-fill"></i><span>&nbsp;Personnel(s)</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="staff-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo e(route('staff.index')); ?>" class="text-decoration-none">
              <i class="fas fa-list"></i><span>&nbsp;Liste du Personnel</span>
            </a>
          </li>
          <li>
            <a href="<?php echo e(route('staff.create')); ?>" class="text-decoration-none">
              <i class="fas fa-plus"></i><span>&nbsp;Nouveau Membre</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#settings-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gear"></i><span>&nbsp; Paramètres</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="settings-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <li>
            <a href="<?php echo e(route('classroom.create')); ?>" class="text-decoration-none">
              <i class="bi bi-columns-gap"></i><span>&nbsp;Classe</span>
            </a>
          </li>
          <li>
            <a href="<?php echo e(route('year.create')); ?>" class="text-decoration-none">
              <i class="bi bi-calendar2-day-fill"></i><span>&nbsp;Année Scolaire</span>
            </a>
          </li>
          <li>
            <a href="<?php echo e(route('subject.create')); ?>" class="text-decoration-none">
              <i class="fas fa-list"></i><span>&nbsp;Matières</span>
            </a>
          </li>
          <li>
            <a href="<?php echo e(route('ratio.create')); ?>" class="text-decoration-none">
              <i class="fas fa-list"></i><span>&nbsp; Coefficient</span>
            </a>
          </li>
        </ul>
      </li><!-- End Settings Nav -->

    </ul>

  </aside><!-- End Sidebar -->
<?php /**PATH C:\laragon\www\School-Manager\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>