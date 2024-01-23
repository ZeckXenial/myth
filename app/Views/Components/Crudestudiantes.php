<!-- app/Views/components/crud_estudiantes.php -->
<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
<?php include(APPPATH . 'Views/Components/headers.php'); ?>

<h2>Administrar Estudiantes</h2>

<!-- Lista de Estudiantes -->
<table id="estudiantesTable" class="table table-bordered">
    <thead>
        <tr>
            <th>RUT Estudiante</th>
            <th>Nombre</th>
            <th>Fecha de Nacimiento</th>
            <th>RUT Apoderado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($estudiantes as $estudiante): ?>
            <tr>
                <td><?= $estudiante['rut_estudiante']; ?></td>
                <td><?= $estudiante['nombre_estudiante']; ?></td>
                <td><?= $estudiante['fecha_nacimiento']; ?></td>
                <td><?= $estudiante['rut_apoderado']; ?></td>
                <td>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarEstudianteModal<?= $estudiante['rut_estudiante'] ?>">Editar</button>
                    <a href="<?= site_url('components/crud_estudiantes/eliminar/' . $estudiante['rut_estudiante']) ?>" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>

            <!-- Modal para Editar Estudiante -->
            <div class="modal fade" id="editarEstudianteModal<?= $estudiante['rut_estudiante'] ?>" tabindex="-1" aria-labelledby="editarEstudianteModalLabel<?= $estudiante['rut_estudiante'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarEstudianteModalLabel<?= $estudiante['rut_estudiante'] ?>">Editar Estudiante</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulario para Editar Estudiante con form floating -->
                            <form action="<?= site_url('components/crud_estudiantes/editar/' . $estudiante['rut_estudiante']) ?>" method="post">
                                <div class="mb-3">
                                    <label for="nombre_edit" class="form-floating">Nombre:</label>
                                    <input type="text" name="nombre_edit" class="form-control" placeholder="<?= $estudiante['nombre_estudiante']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="fecha_nacimiento_edit" class="form-floating">Fecha de Nacimiento:</label>
                                    <input type="text" name="fecha_nacimiento_edit" class="form-control" placeholder="<?= $estudiante['fecha_nacimiento']; ?>" required>
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

<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarEstudianteModal">Agregar Estudiante</button>

<div class="modal fade" id="agregarEstudianteModal" tabindex="-1" aria-labelledby="agregarEstudianteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarEstudianteModalLabel">Agregar Estudiante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('components/crud_estudiantes/agregar') ?>" method="post">
                    <div class="mb-3">
                        <label for="rut" class="form-floating">RUT:</label>
                        <input type="text" name="rut" class="form-control <?= (isset($validation) && $validation->hasError('rut')) ? 'is-invalid' : 'is-valid'; ?>" required>
                        <?php if (isset($validation) && $validation->hasError('rut')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('rut'); ?></div>
                        <?php endif; ?>
                    </div>
                    <!-- Agrega aquí los demás campos con form floating y validación de Bootstrap -->
                    <button type="submit" class="btn btn-success">Agregar Estudiante</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include(APPPATH . 'Views/Components/toast.php'); ?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
