<!-- app/Views/components/asistencia.php -->
<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<?php include(APPPATH . 'Views/Components/headers.php');?>

<h2>Registro de Asistencias</h2>

<!-- Lista de Asistencias -->
<table id="asistenciasTable" class="table table-bordered">
    <thead>
        <tr>
            <th>RUT Estudiante</th>
            <th>Nombre Estudiante</th>
            <th>Fecha Asistencia</th>
            <th>Asistió</th>
            <th>Semestre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($asistencias as $asistencia): ?>
            <tr>
                <td><?= $asistencia['rut_estudiante']; ?></td>
                <td><?= $nombres_estudiantes[$asistencia['rut_estudiante']] ?? ''; ?></td>
                <td><?= $asistencia['fecha_asistencia']; ?></td>
                <td><?= $asistencia['asistio'] ? 'Sí' : 'No'; ?></td>
                <td><?= $asistencia['semestre']; ?></td>
                <td>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarAsistenciaModal<?= $asistencia['id_asistencia'] ?>">Editar</a>
                    <a href="<?= site_url('components/crud_asistencias/eliminar/' . $asistencia['id_asistencia']) ?>" class="btn btn-danger">Eliminar</a>
                </td>
            </tr>

            <!-- Modal para editar asistencia -->
            <div class="modal fade" id="editarAsistenciaModal<?= $asistencia['id_asistencia'] ?>" tabindex="-1" aria-labelledby="editarAsistenciaModalLabel<?= $asistencia['id_asistencia'] ?>" aria-hidden="true">
                <!-- ... Contenido del modal ... -->
            </div>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Formulario para Agregar Asistencia -->
<div class="modal fade" id="agregarAsistenciaModal" tabindex="-1" aria-labelledby="agregarAsistenciaModalLabel" aria-hidden="true">
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarAsistenciaModalLabel">Agregar Asistencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('Crudasistencias/agregar') ?>" method="post">
                    <!-- Campo RUT Estudiante -->
                    <div class="mb-3">
                        <label for="rut_estudiante" class="form-label">RUT Estudiante</label>
                        <!-- Dropdown con los estudiantes -->
                        <select class="form-select" id="rut_estudiante" name="rut_estudiante" required>
                            <?php foreach ($estudiantes as $estudiante): ?>
                                <option value="<?= $estudiante['rut_estudiante'] ?>"><?= $estudiante['nombre_estudiante'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Campo Asistió -->
                    <div class="mb-3">
                        <label for="asistio" class="form-label">Asistió</label>
                        <select class="form-select" id="asistio" name="asistio" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>

                    <!-- Campo Semestre -->
                    <div class="mb-3">
                        <label for="semestre" class="form-label">Semestre</label>
                        <input type="text" class="form-control" id="semestre" name="semestre" required>
                    </div>

                    <!-- Campo Fecha y Hora (deshabilitado) -->
                    <div class="mb-3">
                        <label for="fecha_asistencia" class="form-label">Fecha y Hora</label>
                        <input type="text" class="form-control" id="fecha_asistencia" name="fecha_asistencia" value="<?= date('Y-m-d H:i:s') ?>" disabled>
                    </div>

                    <button type="submit" class="btn btn-primary">Agregar Asistencia</button>
                </form>
            </div>
        </div>
    </div>
</div>

<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#agregarAsistenciaModal">Agregar Asistencia</button>

<?php include(APPPATH . 'Views/Components/toast.php');?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
