<div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h5>Mi Información</h5>
            </div>
            <?php if(empty($usuario['nombre'] ?? '')) ?>
            <div class="alert alert-danger">
                    <p>La sesion se ha vencido.</p>
                </div>
         
            <div class="card-body">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <p><?= $error ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <p><strong>Nombre:</strong> <?= $usuario['nombre'] ?></p>
                <p><strong>Email:</strong> <?= $usuario['email'] ?></p>
                <p><strong>Especialidad:</strong> <?= $usuario['especialidad'] ?></p>

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarModal">Editar</button>
            </div>
          
        </div>
    </div>

    <!-- Modal de Edición -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Editar Información</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
