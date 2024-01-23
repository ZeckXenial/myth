<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
<?php include(APPPATH . 'Views/Components/backbtn.php'); ?>
<?php include(APPPATH . 'Views/Components/headers.php'); ?>

<h2>Editar Información de Apoderados</h2>

<!-- Lista de Apoderados -->
<table id="apoderadosTable" class="table table-bordered">
    <thead>
        <tr>
            <th>RUT Apoderado</th>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Fecha de Nacimiento</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($apoderados as $apoderado): ?>
            <tr>
                <td><?= $apoderado['rut_apoderado']; ?></td>
                <td><?= $apoderado['nombre_apoderado']; ?></td>
                <td><?= $apoderado['telefono_apoderado']; ?></td>
                <td><?= $apoderado['direccion_apoderado']; ?></td>
                <td><?= $apoderado['fechanace_apoderado']; ?></td>
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarApoderadoModal<?= $apoderado['rut_apoderado'] ?>">Editar</button>
                    <a href="<?= site_url('components/crud_apoderados/eliminar/' . $apoderado['rut_apoderado']) ?>" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>

            <!-- Modal para Editar Apoderado -->
            <div class="modal fade" id="editarApoderadoModal<?= $apoderado['rut_apoderado'] ?>" tabindex="-1" aria-labelledby="editarApoderadoModalLabel<?= $apoderado['rut_apoderado'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarApoderadoModalLabel<?= $apoderado['rut_apoderado'] ?>">Editar Apoderado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulario para Editar Apoderado con form floating -->
                            <form action="<?= site_url('components/crud_apoderados/editar/' . $apoderado['rut_apoderado']) ?>" method="post">
                                <div class="mb-3">
                                    <label for="nombre_edit" class="form-floating">Nombre:</label>
                                    <input type="text" name="nombre_edit" class="form-control" value="<?= $apoderado['nombre_apoderado']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="telefono_edit" class="form-floating">Teléfono:</label>
                                    <input type="text" name="telefono_edit" class="form-control" value="<?= $apoderado['telefono_apoderado']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="direccion_edit" class="form-floating">Dirección:</label>
                                    <input type="text" name="direccion_edit" class="form-control" value="<?= $apoderado['direccion_apoderado']; ?>" required>
                                </div>
                                <!-- Agrega aquí los demás campos con form floating y placeholders -->
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Botón para Agregar Apoderado -->
<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarApoderadoModal">Agregar Apoderado</button>

<!-- Modal para Agregar Apoderado -->
<div class="modal fade" id="agregarApoderadoModal" tabindex="-1" aria-labelledby="agregarApoderadoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarApoderadoModalLabel">Agregar Apoderado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para Agregar Apoderado con form floating -->
                <form action="<?= site_url('components/crud_apoderados/agregar') ?>" method="post">
                    <div class="mb-3">
                        <label for="rut" class="form-floating">RUT:</label>
                        <input type="text" name="rut" class="form-control <?= (isset($validation) && $validation->hasError('rut')) ? 'is-invalid' : ''; ?>" required>
                        <?php if (isset($validation) && $validation->hasError('rut')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('rut'); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-floating">Nombre:</label>
                        <input type="text" name="nombre" class="form-control <?= (isset($validation) && $validation->hasError('nombre')) ? 'is-invalid' : ''; ?>" required>
                        <?php if (isset($validation) && $validation->hasError('nombre')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('nombre'); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-floating">Teléfono:</label>
                        <input type="text" name="telefono" class="form-control <?= (isset($validation) && $validation->hasError('telefono')) ? 'is-invalid' : ''; ?>" required>
                        <?php if (isset($validation) && $validation->hasError('telefono')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('telefono'); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-floating">Dirección:</label>
                        <input type="text" name="direccion" class="form-control <?= (isset($validation) && $validation->hasError('direccion')) ? 'is-invalid' : ''; ?>" required>
                        <?php if (isset($validation) && $validation->hasError('direccion')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('direccion'); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_nace" class="form-floating">Fecha de Nacimiento:</label>
                        <input type="date" name="fecha_nace" class="form-control <?= (isset($validation) && $validation->hasError('fecha_nace')) ? 'is-invalid' : ''; ?>" required>
                        <?php if (isset($validation) && $validation->hasError('fecha_nace')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('fecha_nace'); ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-success">Agregar Apoderado</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include(APPPATH . 'Views/Components/toast.php'); ?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
