  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link text-decoration-none"
                href="{{ route('dashboard.index') }}">
                <i class="fas fa-home"></i>
                <span>&nbsp; Accueil</span>
            </a>
        </li><!-- End Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('note.create') }}">
              <i class="bi bi-calculator-fill"></i>
              <span>Les Notes</span>
            </a>
          </li>



        <li class="nav-item">
            <a class="nav-link collapsed " data-bs-target="#students-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-briefcase-fill" ></i><span>&nbsp;Elèves</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="students-nav"
                class="nav-content collapse "data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('student.index') }}"
                        class="text-decoration-none">
                        <i class="fas fa-list"></i><span>&nbsp;Liste des élèves</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.create') }}"
                        class="text-decoration-none">
                        <i class="fas fa-plus"></i><span>&nbsp;Nouvel Elève</span>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed " data-bs-target="#settings-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-gear" ></i><span>&nbsp; Paramètres</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="settings-nav" class="nav-content collapse "data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('classroom.create') }}"
                        class="text-decoration-none">
                        <i class="bi bi-columns-gap"></i><span>&nbsp;Classe</span>
                    </a>
                </li>
                    <ul id="settings-nav"class="nav-content collapse "data-bs-parent="#sidebar-nav">
                        <li>
                            <a href="{{ route('year.create') }}"
                                class="text-decoration-none">
                                <i class="bi bi-calendar2-day-fill"></i><span>&nbsp;Année Scolaire</span>
                            </a>
                        </li>
                            <ul id="settings-nav"class="nav-content collapse "data-bs-parent="#sidebar-nav">
                                <li>
                                    <a href="{{ route('subject.create') }}"
                                        class="text-decoration-none">
                                        <i class="fas fa-list"></i><span>&nbsp;Matières</span>
                                    </a>
                                </li>
                            </ul>
                                <ul id="settings-nav"class="nav-content collapse "data-bs-parent="#sidebar-nav">
                                    <li>
                                        <a href="{{ route('ratio.create') }}"
                                            class="text-decoration-none">
                                            <i class="fas fa-list"></i><span>&nbsp; Coefficient</span>
                                        </a>
                                    </li>
                                </ul>
                    </ul>
            </ul>
        </li>

    </ul>

  </aside><!-- End Sidebar-->
