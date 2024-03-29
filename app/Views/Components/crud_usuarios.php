<?php include(APPPATH . 'Views/Components/headers.php');?>
<div class="container">
    <?php include(APPPATH . 'Views/Components/NavBar.php');?>
    <h1 class="text-center ">Administracion de usuarios</h1>

    <table id="usuariosTable" class="table position-absolute caption-top table-bordered table-responsive table-hover table-striped scroller dataTable">
    <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Especialidad</th> 
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['nombre']; ?></td>
                    <td><?= $user['email']; ?></td>
                    <td><?= $user['nombre_rol']; ?></td>
                    <td><?= $user['especialidad']; ?></td> 
                    <td>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal<?= $user['user_id'] ?>">Editar</a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarUsuarioModal<?= $user['user_id'] ?>">Eliminar</button>
                    </td>
                </tr>

                <div class="modal fade" data-backdrop="static" id="editarUsuarioModal<?= $user['user_id'] ?>" tabindex="-1" aria-labelledby="editarUsuarioModalLabel<?= $user['user_id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editarUsuarioModalLabel<?= $user['user_id'] ?>">Editar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="<?= site_url('crud_usuarios/editar/' . $user['user_id']) ?>" method="post"> 
                                    <div class="mb-3">
                                        <label for="nombre_edit" class="form-floating">Nombre:</label>
                                        <input type="text" name="nombre_edit" class="form-control" value="<?= $user['nombre']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email_edit" class="form-floating">Email:</label>
                                        <input type="email" name="email_edit" class="form-control" value="<?= $user['email']; ?>" >
                                    </div>
                                    <div class="mb-3">
                                    <label for="especialidad" class="form-floating">Especialidad:</label>
                                    <input type="text" name="especialidad" class="form-control <?= (isset($validation) && $validation->hasError('especialidad')) ? 'is-invalid' : 'is-valid'; ?>" value="<?= (isset($validation)) ? set_value('especialidad') : ''; ?>"required >
                                    <?php if (isset($validation) && $validation->hasError('especialidad')): ?>
                                        <div class="invalid-feedback"><?= $validation->getError('especialidad'); ?></div>
                                    <?php endif; ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password_edit" class="form-floating">Nueva Contraseña:</label>
                                        <div class="input-group">
                                            <input type="password" name="password_edit" class="form-control" placeholder="Ingrese nueva contraseña">
                                            <button class="btn btn-outline-secondary reveal-password" onclick="mostrarContrasena()" type="button">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rol_edit" class="form-floating">Rol:</label>
                                        <select name="id_rol" class="form-select" required>
                                            <option value="1" <?= ($user['id_rol'] == '1') ? 'selected' : ''; ?>>Profesor</option>
                                            <option value="2" <?= ($user['id_rol'] == '2') ? 'selected' : ''; ?>>Director</option>
                                            <option value="3" <?= ($user['id_rol'] == '3') ? 'selected' : ''; ?>>UTP</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="eliminarUsuarioModal<?= $user['user_id'] ?>" tabindex="-1" aria-labelledby="eliminarUsuarioModalLabel<?= $user['user_id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="eliminarUsuarioModalLabel<?= $user['user_id'] ?>">Eliminar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>¿Está seguro de que desea eliminar este usuario?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <a href="<?= site_url('crud_usuarios/eliminar/' . $user['user_id']) ?>" class="btn btn-danger">Eliminar</a>
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
                    <form action="<?= site_url('crud_usuarios/agregar') ?>" class="was-validated" method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-floating">Nombre:</label>
                            <input type="text" name="nombre" class="form-control <?= (isset($validation) && $validation->hasError('nombre')) ? 'is-invalid' : 'is-valid'; ?>" value="<?= (isset($validation)) ? set_value('nombre') : ''; ?>" required>
                            <?php if (isset($validation) && $validation->hasError('nombre')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('nombre'); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-floating">Email:</label>
                            <input type="email" name="email" class="form-control <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : 'is-valid'; ?>" value="<?= (isset($validation)) ? set_value('email') : ''; ?>" required>
                            <?php if (isset($validation) && $validation->hasError('email')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="especialidad" class="form-floating">Especialidad:</label>
                            <input type="text" name="especialidad" class="form-control <?= (isset($validation) && $validation->hasError('especialidad')) ? 'is-invalid' : 'is-valid'; ?>" value="<?= (isset($validation)) ? set_value('especialidad') : ''; ?>"required >
                            <?php if (isset($validation) && $validation->hasError('especialidad')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('especialidad'); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-floating">Contraseña:</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control <?= (isset($validation) && $validation->hasError('password')) ? 'is-invalid' : 'is-valid'; ?>" value="<?= (isset($validation)) ? set_value('password') : ''; ?>" required id="password">
                                <button class="btn btn-outline-secondary reveal-password" type="button">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <?php if (isset($validation) && $validation->hasError('password')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('password'); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="id_rol" class="form-floating">Rol:</label>
                            <select name="id_rol" class="form-select <?= (isset($validation) && $validation->hasError('id_rol')) ? 'is-invalid' : 'is-valid'; ?>" required>
                                <option value="1">Profesor</option>
                                <option value="2">Director</option>
                                <option value="3">UTP</option>
                            </select>
                            <?php if (isset($validation) && $validation->hasError('id_rol')): ?>
                                <div class="invalid-feedback"><?= $validation->getError('id_rol'); ?></div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="mx-auto btn btn-success">Agregar Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
</div>
<?php include(APPPATH . 'Views/Components/toast.php');?>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
