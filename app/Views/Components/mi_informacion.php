<?php include(APPPATH . 'Views/Components/headers.php'); 
include(APPPATH . 'Views/Components/NavBar.php'); ?>

<body class="container">
<div class="container mt-5">
    <div class="card shadow-lg rounded-lg">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <div class="me-3">
                <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-size: 1.5rem;">
                    <?= strtoupper(substr($usuario['nombre'] ?? 'U', 0, 1)) ?>
                </div>
            </div>
            <h5 class="m-0">Mi Información</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th>Nombre:</th>
                    <td><?= $usuario['nombre'] ?></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><?= $usuario['email'] ?></td>
                </tr>
                <tr>
                    <th>Especialidad:</th>
                    <td><?= $usuario['especialidad'] ?></td>
                </tr>
            </table>

            <button class="btn btn-outline-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#editarModal">
                <i class="bi bi-pencil-square"></i> Editar Información
            </button>
        </div>
    </div>
</div>

<!-- Modal de Edición -->
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editarModalLabel">Editar Información</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('usuario/actualizar_informacion') ?>" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= $usuario['nombre'] ?>" required>
                        <label for="nombre">Nombre</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="especialidad" name="especialidad" placeholder="Especialidad" value="<?= $usuario['especialidad'] ?>">
                        <label for="especialidad">Especialidad</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Nueva Contraseña" minlength="6">
                        <label for="password">Nueva Contraseña</label>
                        <small class="text-muted">Debe tener al menos 6 caracteres.</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save"></i> Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include(APPPATH . 'Views/Components/toast.php'); 
include(APPPATH . 'Views/Components/footer.php'); ?>
