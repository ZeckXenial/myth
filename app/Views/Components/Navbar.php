<div class="container  mx-auto">
  <nav class="navbar mx-auto shadow-drop-2-center navbar-expand-lg navbar-light sticky-top">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto" id="btnCrudUsuarios">
          <?php if (session()->get('idrol') === '2' || session()->get('idrol') === '3'): ?>
            <?php if (strpos(current_url(), 'dashboard') === false): ?>
              <li class="nav-item">
                <a class="btn btn-primary" href="<?= site_url('admin/dashboard') ?>">Dashboard</a>
              </li>
            <?php endif; ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('usuarios') ?>">Administrar Usuarios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= site_url('estadisticas') ?>">Estadisticas</a>
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

      <!-- Men迆 de usuario -->
      <div class="user-menu-container">
        <div class="menu-user btn  nav-item dropdown">
           <a class="nav-link   dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi  bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-right" aria-labelledby="userDropdown">
                            <?php if (session()->has('idrol')): ?>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#otpModal">Código OTP</a></li>
                            <a class="dropdown-item" href="<?= site_url('usuario/mi_informacion') ?>">Mi Información</a>
                             <?php endif; ?>
                            <li><a class="dropdown-item btn" href="<?= site_url('logout') ?>">Cerrar sesión</a></li>
                        </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- Modal OTP -->
  <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="otpModalLabel">Verificar OTP</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="otpForm" >
            <div class="form-group">
              <label for="rut">RUT</label>
              <input type="number" class="form-control" id="rut" name="rut" required>
            </div>
            <div class="form-group">
              <label for="otp">Codigo OTP</label>
              <input type="number" class="form-control" id="otp" name="otp" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('rut').addEventListener('input', function(event) {
  let value = event.target.value.replace(/[^0-9]/g, ''); // Eliminar cualquier car芍cter que no sea n迆mero
  if (value.length > 8) {
    value = value.slice(0, 8) + '-' + value.slice(8);
  }
  event.target.value = value;
});
</script>
