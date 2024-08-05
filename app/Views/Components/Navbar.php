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
        <div class="user-menu-container">
                    <div class="menu-user nav-item dropdown ml-auto">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#otpModal">Código OTP</a></li>
                            <a class="dropdown-item" href="<?= site_url('usuario/mi_informacion') ?>">Mi Información</a>
                            <li><a class="dropdown-item btn" href="<?= site_url('logout') ?>">Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="otpModalLabel">Verificar OTP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="otpForm">
                            <div class="form-group">
                                <label for="rut" >RUT</label>
                                <input type="number" class="form-control" prefix="99999999-9" id="rut" name="rut" required>
                            </div>
                            <div class="form-group">
                                <label for="otp">Código OTP</label>
                                <input type="number" class="form-control" id="otp" name="otp" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>