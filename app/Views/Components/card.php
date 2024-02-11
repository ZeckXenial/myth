<div class="card">
  <div class="card-header">
    Información del Usuario
  </div>
  <div class="card-body">
    <p class="card-title">Nombre del usuario:<?= session()->get('username'); ?></p>
    <p class="card-text">Correo electrónico: <?= session()->get('email');; ?></p>
    <p class="card-text">Rol: <?= session()->get('role');; ?></p>
  </div>
</div>
