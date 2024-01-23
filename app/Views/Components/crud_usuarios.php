<!-- app/Views/components/crud_usuarios.php -->
<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<?php include(APPPATH . 'Views/Components/headers.php');?>
<h2>Administracion de Usuarios</h2>

<table id="usuariosTable" class="table table-bordered">
    <thead>
        <tr>
            <th>RUT</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['rut']; ?></td>
                <td><?= $user['full_name']; ?></td>
                <td><?= $user['email']; ?></td>
                <td><?= $user['role']; ?></td>
                <td>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal<?= $user['rut'] ?>">Editar</a>
                    <a href="<?= site_url('components/crud_usuarios/eliminar/' . $user['rut']) ?>" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>

            <div class="modal fade" id="editarUsuarioModal<?= $user['rut'] ?>" tabindex="-1" aria-labelledby="editarUsuarioModalLabel<?= $user['rut'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarUsuarioModalLabel<?= $user['rut'] ?>">Editar Usuario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= site_url('components/crud_usuarios/editar/' . $user['rut']) ?>" method="post">
                                <div class="mb-3">
                                    <label for="nombre_edit" class="form-floating">Nombre:</label>
                                    <input type="text" name="nombre_edit" class="form-control" placeholder="<?= $user['full_name']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email_edit" class="form-floating">Email:</label>
                                    <input type="email" name="email_edit" class="form-control" placeholder="<?= $user['email']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="rol_edit" class="form-floating">Rol:</label>
                                    <select name="rol_edit" class="form-select" required>
                                        <option value="directive" <?= ($user['role'] == 'directive') ? 'selected' : ''; ?>>Directive</option>
                                        <option value="teacher" <?= ($user['role'] == 'teacher') ? 'selected' : ''; ?>>Teacher</option>
                                        <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </tbody>
</table>

<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">Agregar Usuario</button>

<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('components/crud_usuarios/agregar') ?>" method="post">
                    <div class="mb-3">
                        <label for="rut" class="form-floating">RUT:</label>
                        <input type="text" name="rut" class="form-control <?= (isset($validation) && $validation->hasError('rut')) ? 'is-invalid' : 'is-valid'; ?>" required>
                        <?php if (isset($validation) && $validation->hasError('rut')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('rut'); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-floating">Nombre:</label>
                        <input type="text" name="nombre" class="form-control <?= (isset($validation) && $validation->hasError('nombre')) ? 'is-invalid' : 'is-valid'; ?>" required>
                        <?php if (isset($validation) && $validation->hasError('nombre')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('nombre'); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-floating">Email:</label>
                        <input type="email" name="email" class="form-control <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : 'is-valid'; ?>" required>
                        <?php if (isset($validation) && $validation->hasError('email')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-floating">Rol:</label>
                        <select name="rol" class="form-select <?= (isset($validation) && $validation->hasError('rol')) ? 'is-invalid' : 'is-valid'; ?>" required>
                            <option value="directive">Directive</option>
                            <option value="teacher">Teacher</option>
                            <option value="admin">Admin</option>
                        </select>
                        <?php if (isset($validation) && $validation->hasError('rol')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('rol'); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-floating">Titulo:</label>
                        <input type="text" name="title" class="form-control <?= (isset($validation) && $validation->hasError('title')) ? 'is-invalid' : 'is-valid'; ?>" required>
                        <?php if (isset($validation) && $validation->hasError('title')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('title'); ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-success">Agregar Usuario</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Agrega esto al final de tu vista -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <?php if (session()->get('success')): ?>
        <div id="toast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?= session()->get('success') ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        <script>
            // Muestra el toast automáticamente
            var toast = new bootstrap.Toast(document.getElementById('toast'));
            toast.show();
        </script>
    <?php endif; ?>
</div>

<?php include(APPPATH . 'Views/Components/toast.php');?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
