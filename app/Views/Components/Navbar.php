<div class="container sticky-top mx-auto">
  <nav class="navbar mx-auto shadow-drop-2-center navbar-expand-lg navbar-light ">
    <div id="navbar-top" class="container">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
  aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

<!-- Contenedor de la barra de navegación -->
<div class="collapse navbar-collapse" id="navbarNav">
  <ul class="navbar-nav ms-auto" id="btnCrudUsuarios">

    <?php 
    $idrol = session()->get('idrol');
    $en_dashboard = strpos(current_url(), 'dashboard') !== false;
    ?>

    <?php if ($idrol === '2' || $idrol === '3'): ?>
      <?php if (!$en_dashboard): ?>
        <li class="nav-item">
          <a class="btn btn-primary btn-sm text-white" href="<?= site_url('admin/dashboard') ?>">
            <i class="bi bi-speedometer2"></i> Panel
          </a>
        </li>
      <?php endif; ?>
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('usuarios') ?>">
          <i class="bi bi-people"></i> Administrar Usuarios
        </a>
      </li>
      <?php if ($idrol === '2'): ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= site_url('estadisticas') ?>">
            <i class="bi bi-bar-chart"></i> Estadísticas
          </a>
        </li>
      <?php endif; ?>
        <li class="nav-item">
        <a class="nav-link" href="<?= site_url('estudiantes') ?>">
          <i class="bi bi-person-plus"></i> Registrar Estudiante
        </a>
      </li>
    <?php elseif ($idrol === '1'): ?>
      <?php if (!$en_dashboard): ?>
        <li class="nav-item">
          <a class="btn btn-primary btn-sm text-white" href="<?= site_url('teacher/dashboard') ?>">
            <i class="bi bi-house-door"></i> Dashboard
          </a>
        </li>
      <?php endif; ?>
    <?php endif; ?>

    <?php if (session()->has('idrol')): ?>
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('cursos') ?>">
          <i class="bi bi-journal"></i> Cursos
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('/horarios') ?>">
          <i class="bi bi-calendar-week"></i> Horarios
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('calendar') ?>">
          <i class="bi bi-calendar-event"></i> Calendario
        </a>
      </li>
    <?php endif; ?>
  </ul>
</div>
      <!-- Men迆 de usuario -->
      <div class="user-menu-container">
  <div class="menu-user btn nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="bi bi-person-circle"></i>
    </a>

    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
      <li><h6 class="dropdown-header text-center">Menú del usuario</h6></li>

      <?php if (session()->has('idrol')): ?>
        <li>
          <a class="text-center dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#otpModal">
            <i class="bi bi-key"></i> Código OTP
          </a>
        </li>
        <li>
          <a class="text-center dropdown-item" href="<?= site_url('usuario/mi_informacion') ?>">
            <i class="bi bi-file-person"></i> Mi Información
          </a>
        </li>
      <?php endif; ?>

      <li><hr class="dropdown-divider"></li>
      <li>
        <a class="text-center dropdown-item btn" href="<?= site_url('logout') ?>">
          <i class="bi bi-box-arrow-right"></i> Cerrar sesión
        </a>
      </li>
    </ul>
  </div>
</div>
    </div>
  </nav>

  <!-- Modal OTP -->
  <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="otpModalLabel">🔒 Verificar OTP</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form id="otpForm">

          <!-- Campo RUT -->
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="rut" name="rut" placeholder="12345678-9" required>
            <label for="rut">📄 RUT</label>
          </div>

          <!-- Campo OTP -->
          <div class="form-floating mb-3">
            <input type="number" class="form-control" id="otp" name="otp" placeholder="000000" required>
            <label for="otp">🔢 Código OTP</label>
          </div>

          <!-- Campo Fecha -->
          <div class="form-floating mb-3">
            <input type="date" class="form-control" id="fecha" name="fecha" required>
            <label for="fecha">📅 Fecha</label>
          </div>
            <div id="loadingSpinner" class="text-center my-3" style="display: none;">
              <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
              </div>
            </div>
          <!-- Botón de Enviar -->
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Enviar</button>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>
</div>

<script>
document.getElementById('rut').addEventListener('input', function(event) {
  let rawValue = event.target.value.replace(/[^0-9kK]/g, ''); // Permitir solo números y 'k'/'K'

  // Validar longitud y agregar el guion antes del dígito verificador
  if (rawValue.length > 8) {
    let cuerpo = rawValue.slice(0, -1); // Todo excepto el último dígito
    let dv = rawValue.slice(-1);       // Último dígito (posible dígito verificador)
    rawValue = `${cuerpo}-${dv}`;
  }

  // Actualizar el valor del input de forma segura
  event.target.value = rawValue.toUpperCase(); // Convertir a mayúsculas para 'K'
});
</script>
 