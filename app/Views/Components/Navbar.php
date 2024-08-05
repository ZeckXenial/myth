<div class="container">
<nav class="navbar mx-auto navbar-expand-lg navbar-light sticky-top">
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
                </ul>
                
                
            </div>
        </div>
        <div class="menu-user " style="font-size: 30px; margin-right:10px;">
                <a class="nav-link"><i class="fas fa-user-circle"></i></a> 
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#otpModal">Código OTP</a></li>
                            <li><a class="dropdown-item" href="#">Mi información</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('logout') ?>">Cerrar sesión</a></li>
                        </ul>
        </div>
  </nav>
 

    <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="otpModalLabel">Verificar OTP</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="otpForm">
                        <div class="form-group">
                            <label for="rut">RUT</label>
                            <input type="text" class="form-control" id="rut" name="rut" required>
                        </div>
                        <div class="form-group">
                            <label for="otp">Código OTP</label>
                            <input type="text" class="form-control" id="otp" name="otp" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>