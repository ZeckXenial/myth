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
            <?php if (empty($usuario['nombre'] ?? '')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p>La sesión se ha vencido.</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <p><?= $error ?></p>
                    <?php endforeach; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <p><strong>Nombre:</strong> <?= $usuario['nombre'] ?></p>
            <p><strong>Email:</strong> <?= $usuario['email'] ?></p>
            <p><strong>Especialidad:</strong> <?= $usuario['especialidad'] ?></p>

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
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $usuario['nombre'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $usuario['email'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="especialidad" class="form-label">Especialidad</label>
                        <input type="text" class="form-control" id="especialidad" name="especialidad" value="<?= $usuario['especialidad'] ?>">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
