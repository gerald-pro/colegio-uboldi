<style>
  [class*="sidebar-dark-"] {
    background: #EF5350;
    background: -webkit-linear-gradient(to right, #EF5350, #EF5350);
    background: linear-gradient(to right, #04005b, #04005b)
  }

  [class*="sidebar-dark"] .user-panel {
    border-bottom: 1px solid #EF5350;
  }

  [class*="sidebar-dark"] .brand-link {
    border-bottom: 1px solid #EF5350;
  }

  .dropdown-toggle a {
    color: #EF5350 !important;
  }
</style>



<aside class="main-sidebar sidebar-dark-primary elevation-4">

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">

      </div>
      <a href="vistas/index3.html" class="brand-link">

        <span class="brand-text font">COLEGIO M. UBOLDI</span>
      </a>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
      <div class="sidebar-search-results">
        <div class="list-group"><a href="#" class="list-group-item">
            <div class="search-title"><strong class="text-light"></strong>N<strong class="text-light"></strong>o<strong
                class="text-light"></strong> <strong class="text-light"></strong>e<strong
                class="text-light"></strong>l<strong class="text-light"></strong>e<strong
                class="text-light"></strong>m<strong class="text-light"></strong>e<strong
                class="text-light"></strong>n<strong class="text-light"></strong>t<strong class="text-light"></strong>
              <strong class="text-light"></strong>f<strong class="text-light"></strong>o<strong
                class="text-light"></strong>u<strong class="text-light"></strong>n<strong
                class="text-light"></strong>d<strong class="text-light"></strong>!<strong class="text-light"></strong>
            </div>
            <div class="search-path"></div>
          </a></div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="inicio" class="nav-link <?php if ($_GET["rutas"] == "inicio") echo 'active' ?>">
            <i class="nav-icon fa fa-home" style="color: #B71C1C ;"></i>
            <p>
              Inicio
              <i class="right fas fa-angle"></i>
            </p>
          </a>
          </i>

        <li class="nav-item">
          <a href="usuarios" class="nav-link <?php if ($_GET["rutas"] == "usuarios") echo 'active' ?>">
            <i class="nav-icon fas fa-user-circle" style="color: #B71C1C;"></i>
            <p>
              Usuarios
              <span class="right badge badge-danger"></span>
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="apoderados" class="nav-link <?php if ($_GET["rutas"] == "apoderados") echo 'active' ?>">
            <i class="nav-icon fas fa-child" style="color: #B71C1C;"></i>
            <p>
              Tutor
              <span class="right badge badge-danger"></span>
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="estudiantes" class="nav-link <?php if ($_GET["rutas"] == "estudiantes") echo 'active' ?>">
            <i class="nav-icon fas fa-graduation-cap" style="color: #B71C1C;"></i>
            <p>
              Estudiantes
              <span class="right badge badge-danger"></span>
            </p>
          </a>
        </li>


        <li class="nav-item">
          <a href="cursos" class="nav-link <?php if ($_GET["rutas"] == "cursos") echo 'active' ?>">
            <i class="nav-icon fas fa-chalkboard" style="color: #B71C1C;"></i>
            <p>
              Cursos
              <span class="right badge badge-danger"></span>
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="cuotas" class="nav-link <?php if ($_GET['rutas'] == 'cuotas') echo 'active' ?>">
            <i class="nav-icon fas fa-file-alt" style="color: #B71C1C;"></i>
            <p>
              Cuotas
              <span class="right badge badge-danger"></span>
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="pagos" class="nav-link <?php if ($_GET['rutas'] == 'pagos') echo 'active' ?>">
            <i class="nav-icon fas fa-money-bill-wave" style="color: #B71C1C;"></i>
            <p>
              Pago de mensualidades
              <span class="right badge badge-danger"></span>
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="reportes" class="nav-link">
            <i class="nav-icon fas fa-chart-pie text-danger"></i>
            <p>Reportes</p>
          </a>
        </li>

        <!-- <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-chart-pie text-danger"></i>
            <p>
              Reportes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="historial-pagos" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Historial de pagos</p>
              </a>
            </li>
          </ul>
        </li> -->
      </ul>
    </nav>
  </div>
</aside>