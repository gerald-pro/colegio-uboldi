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
    <!-- Panel del usuario -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image"></div>
      <a href="#" class="brand-link">
        <span class="brand-text font">COLEGIO M. UBOLDI</span>
      </a>
    </div>

    <!-- Menú Lateral -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php
        // Opciones del menú disponibles según el rol
        $permiso = [
          'administradora' => ['inicio', 'usuarios', 'apoderados', 'estudiantes', 'cursos', 'cuotas', 'pagos', 'reportes'],
          'contadora' => ['inicio', 'apoderados', 'estudiantes', 'cursos', 'cuotas', 'pagos'],
          'secretaria' => ['inicio', 'reportes']
        ];

        // Verificar que el rol del usuario esté en sesión
        $rolUsuario = $_SESSION['rol'] ?? null;

        if ($rolUsuario && isset($permiso[$rolUsuario])) {
          $rutasPermitidas = $permiso[$rolUsuario];

          // Generar el menú dinámico
          $menuItems = [
            'inicio' => ['icon' => 'fa-home', 'label' => 'Inicio'],
            'usuarios' => ['icon' => 'fa-user-circle', 'label' => 'Usuarios'],
            'apoderados' => ['icon' => 'fa-child', 'label' => 'Tutor'],
            'estudiantes' => ['icon' => 'fa-graduation-cap', 'label' => 'Estudiantes'],
            'cursos' => ['icon' => 'fa-chalkboard', 'label' => 'Cursos'],
            'cuotas' => ['icon' => 'fa-file-alt', 'label' => 'Cuotas'],
            'pagos' => ['icon' => 'fa-money-bill-wave', 'label' => 'Pago de mensualidades'],
            'reportes' => ['icon' => 'fa-chart-pie', 'label' => 'Reportes']
          ];

          foreach ($menuItems as $ruta => $item) {
            if (in_array($ruta, $rutasPermitidas)) {
              echo '
                    <li class="nav-item">
                      <a href="' . $ruta . '" class="nav-link ' . (($_GET["rutas"] ?? '') === $ruta ? 'active' : '') . '">
                        <i class="nav-icon fas ' . $item['icon'] . '" style="color: #B71C1C;"></i>
                        <p>' . $item['label'] . '</p>
                      </a>
                    </li>';
            }
          }
        } else {
          echo '<p class="text-white">Acceso no autorizado</p>';
        }
        ?>
      </ul>
    </nav>
  </div>
</aside>