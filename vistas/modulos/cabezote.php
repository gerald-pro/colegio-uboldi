 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">

   <!-- Right navbar links -->
   <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
   <ul class="navbar-nav ml-auto">
     <li class="nav-item dropdown">
       <a class="nav-link" data-toggle="dropdown" href="#" role="button">
         <i class="fas fa-user"></i>
         <?php
          // Mostrar el nombre del usuario y el rol
          echo htmlspecialchars($_SESSION['usuario']) . " (" . htmlspecialchars($_SESSION['rol']) . ")";
          ?>
         <i class="fas fa-angle-down ml-1"></i>
       </a>
       <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <!--  <a href="perfil" class="dropdown-item">
           <i class="fas fa-user-cog mr-2"></i> Mi Perfil
         </a> -->
         <div class="dropdown-divider"></div>
         <a href="salir" class="dropdown-item">
           <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
         </a>
       </div>
     </li>
   </ul>
 </nav>
 <!-- /.navbar -->