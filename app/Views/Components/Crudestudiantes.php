<!-- app/Views/components/crud_estudiantes.php -->
<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
<?php include(APPPATH . 'Views/Components/headers.php'); ?>

<h2 class="text-center">Administrar Estudiantes</h2>

<!-- Verificar si hay estudiantes -->
<?php if (!empty($estudiantes)): ?>
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
                                <form action="<?= site_url('components/crud_estudiantes/editar/' . $estudiante['rut_estudiante']) ?>" method="post">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nombre_edit" class="form-control" placeholder="Nombre" value="<?= $estudiante['nombre_estudiante']; ?>" required>
                                        <label for="nombre_edit">Nombre:</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" name="fecha_nacimiento_edit" class="form-control" placeholder="Fecha de Nacimiento" value="<?= $estudiante['fecha_nacimiento']; ?>" required>
                                        <label for="fecha_nacimiento_edit">Fecha de Nacimiento:</label>
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
<?php else: ?>
    <p class="text-center">No hay estudiantes registrados actualmente.</p>
<?php endif; ?>

<!-- Modal para Agregar Estudiante -->
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
                    <div class="form-floating mb-3">
                        <input type="text" name="rut" class="form-control <?= (isset($validation) && $validation->hasError('rut')) ? 'is-invalid' : 'is-valid'; ?>" placeholder="RUT" required>
                        <label for="rut">RUT:</label>
                        <?php if (isset($validation) && $validation->hasError('rut')): ?>
                            <div class="invalid-feedback"><?= $validation->getError('rut'); ?></div>
                        <?php endif; ?>
                    </div>
                    <!-- Campos adicionales de estudiante -->
                    <button type="submit" class="btn btn-success">Agregar Estudiante</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts y DataTables -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#estudiantesTable').DataTable();
    });
</script>

<?php include(APPPATH . 'Views/Components/toast.php'); ?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
