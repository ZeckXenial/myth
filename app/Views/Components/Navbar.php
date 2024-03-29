<nav class="navbar mx-auto navbar-expand-lg navbar-light sticky-top ">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
             
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto" id="btnCrudUsuarios">
                <?php if (session()->get('idrol') === '2' or session()->get('idrol') === '3'): ?>
                    <?php if (strpos(current_url(), 'dashboard') === false): ?>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="<?= site_url('admin/dashboard') ?>">Dashboard</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('crud_usuarios') ?>">Administrar Usuarios</a>
                    </li>
                    
                <?php elseif (session()->get('idrol') === '1'): ?>
                    <?php if (strpos(current_url(), 'dashboard') === false): ?>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="<?= site_url('teacher/dashboard') ?>">Dashboard</a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if (session()->has('idrol')): ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('cursos') ?>">Cursos</a>
                </li>
              
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('estudiantes') ?>">Registrar Estudiante</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="btn btn-primary" href="<?= site_url('logout') ?>">Cerrar sesión</a>
                </li>
            </ul>
           
        </div>
    </div>

</nav>
