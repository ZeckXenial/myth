<nav class="navbar navbar-expand-lg navbar-light sticky-top ">
    <div class="container">
        <a class="navbar-brand" href=""><?= session()->get('establecimiento')?></a>
        
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
            
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto" id="btnCrudUsuarios">
                <?php if (session()->get('role') === 'directive'): ?>
                    <li class="nav-item">
                        <a class="nav-link btn" href="<?= site_url('crud_usuarios') ?>">Administrar Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('establecimientos') ?>">Ver Establecimientos</a>
                    </li>
                <?php elseif (session()->get('role') === 'teacher'): ?>
                    
                <?php endif; ?>
                    
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('cursos') ?>">Cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('crud_apoderados') ?>">Editar Info Apoderados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('crudestudiante') ?>">Registrar Estudiante</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="<?= site_url('logout') ?>"s>Cerrar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
