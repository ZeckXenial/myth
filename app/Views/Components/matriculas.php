<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
<?php include(APPPATH . 'Views/Components/headers.php'); ?>
<body>

<div class="container my-4">
    <h1 class="text-center">Gestión de Matrículas</h1>

    <!-- Botón para abrir el formulario de nueva matrícula -->

    <!-- Tabla de estudiantes y apoderados registrados -->
    <table id="matriculasTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre del Estudiante</th>
                <th>Fecha de Nacimiento</th>
                <th>Curso</th>
                <th>Nombre del Apoderado</th>
                <th>Teléfono del Apoderado</th>
                <th>Email del Apoderado</th>
                <th>Fecha de Matrícula</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($matriculas as $matricula): ?>
            <tr>
                <td><?= esc($matricula->nombre_estudiante); ?></td>
                <td><?= esc($matricula->fecha_nacimiento); ?></td>
                <td><?= esc($matricula->grado), ' - ', esc($matricula->nombre); ?></td>
                <td><?= esc($matricula->nombre_apoderado); ?></td>
                <td><?= esc($matricula->numero_telefono); ?></td>
                <td><?= esc($matricula->email); ?></td>
                <td><?= esc($matricula->fecha_matriculacion); ?></td>
                <td><?= esc($matricula->estado); ?></td>
                <td>
    <a href="<?= site_url('matriculas/editar/' . $matricula->estudiante_id .'/'. $matricula->apoderado_id.'/'. $matricula->matricula_id); ?>" class="btn btn-warning btn-sm">Editar</a>
    <a href="<?= site_url('matriculas/eliminar/' . $matricula->matricula_id); ?>" class="btn btn-danger gap btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar esta matrícula?');">Eliminar</a>
</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="button btn button-primary mx-auto" id="btnIngresarMatricula" class="btn btn-primary mb-4">Ingresar Matrícula</button>
</div>

<!-- Modal para agregar nueva matrícula -->
<div class="modal fade" id="modalIngresarMatricula" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Ingresar Nueva Matrícula</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= site_url('matriculas/guardar') ?>" method="post" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                        <input type="text" name="nombre_estudiante" class="form-control" placeholder="Nombre del Estudiante" required>
                        <label for="nombre_estudiante">Nombre del Estudiante</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="fecha_nacimiento" class="form-control" placeholder="Fecha de Nacimiento" required>
                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="curso_id" class="form-select" required>
                        <option value="">Seleccione un curso</option>
                        <?php foreach ($cursos as $curso): ?>
                            <option value="<?= esc($curso['curso_id']); ?>"><?= esc($curso['grado']),' - ',esc($curso['nombre_nivel']);  ?></option>
                        <?php endforeach; ?>>
                        </select>
                        <label for="curso_id">Curso</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" id="rut_estudiante" name="rut_estudiante" class="form-control" placeholder="RUT del Estudiante" required>
                        <label for="rut_estudiante">RUT del Estudiante</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="nombre_apoderado" class="form-control" placeholder="Nombre del Apoderado" required>
                        <label for="nombre_apoderado">Nombre del Apoderado</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="tel" name="numero_telefono" class="form-control" placeholder="Teléfono del Apoderado" required>
                        <label for="numero_telefono">Teléfono del Apoderado</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" id="rut_apoderado" name="rut_apoderado" class="form-control" placeholder="RUT del Apoderado" required>
                        <label for="rut_apoderado">RUT del apoderado</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email del Apoderado" required>
                        <label for="email">Email del Apoderado</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="fecha_matricula" class="form-control" placeholder="Fecha de Matrícula" required>
                        <label for="fecha_matricula">Fecha de Matrícula</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="estado" class="form-select" required>
                            <option value="Matriculado">Matriculado</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Anulado">Anulado</option>
                        </select>
                        <label for="estado">Estado</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Matrícula</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#matriculasTable').DataTable({
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-MX.json"
            }
        });
        document.getElementById('rut_estudiante').addEventListener('input', function(event) {
        let value = event.target.value.replace(/[^0-9]/g, ''); // Eliminar cualquier car芍cter que no sea n迆mero
        if (value.length > 8) {
            value = value.slice(0, 8) + '-' + value.slice(8);
        }
        event.target.value = value;
        });
        document.getElementById('rut_apoderado').addEventListener('input', function(event) {
        let value = event.target.value.replace(/[^0-9]/g, ''); // Eliminar cualquier car芍cter que no sea n迆mero
        if (value.length > 8) {
            value = value.slice(0, 8) + '-' + value.slice(8);
        }
        event.target.value = value;
        });
        $('#btnIngresarMatricula').on('click', function() {
            $('#modalIngresarMatricula').modal('show');
        });
    });
</script>

</body>
<?php include(APPPATH . 'Views/Components/toast.php'); include(APPPATH . 'Views/Components/footer.php'); ?>
</html>

