<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<?php include(APPPATH . 'Views/Components/headers.php');?>

<div class="container mt-4">
    <h2 class="text-center h1">Gestión de Estudiantes y Apoderados</h2>

    <!-- Formulario para agregar nuevo estudiante y apoderado -->
   <!-- Botón para abrir el modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearEstudianteModal">
    Agregar Estudiante y Apoderado
</button>

<!-- Modal para agregar estudiante y apoderado -->
<div class="modal mx-auto fade" id="crearEstudianteModal" data-backdrop="static" tabindex="-1" aria-labelledby="crearEstudianteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearEstudianteModalLabel">Agregar Estudiante y Apoderado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulario para agregar estudiante y apoderado -->
                <form action="<?= site_url('estudiantes/agregar') ?>" method="post">
                    <!-- Campos del estudiante -->
                    <div class="mb-3">
                        <label for="nombre_estudiante" class="form-label">Nombre del Estudiante</label>
                        <input type="text" class="form-control" id="nombre_estudiante" name="nombre_estudiante" placeholder="Nombre del estudiante" required>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_nacimiento_estudiante" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento_estudiante" name="fecha_nacimiento_estudiante" required>
                    </div>
                    <div class="mb-3">
                    <label for="nivel_estudiante" class="form-label">Nivel</label>
                    <select class="form-select" id="nivel_estudiante" name="nivel_estudiante" required>
                        <!-- Iterar sobre los niveles obtenidos desde el controlador -->
                        <?php foreach ($niveles as $nivel): ?>
                            <option value="<?= $nivel['nivel_id'] ?>"><?= $nivel['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                    <!-- Campos del apoderado -->
                    <div class="mb-3">
                        <label for="nombre_apoderado" class="form-label">Nombre del Apoderado</label>
                        <input type="text" class="form-control" id="nombre_apoderado" name="nombre_apoderado" placeholder="Nombre del apoderado" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono_apoderado" class="form-label">Teléfono del Apoderado</label>
                        <input type="tel" class="form-control" id="telefono_apoderado" name="telefono_apoderado" placeholder="Teléfono del apoderado" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_apoderado" class="form-label">Correo Electrónico del Apoderado</label>
                        <input type="email" class="form-control" id="email_apoderado" name="email_apoderado" placeholder="Correo electrónico del apoderado" required>
                    </div>
                    <!-- Botón para enviar el formulario -->
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Tabla para mostrar la lista de estudiantes y apoderados -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Estudiantes y Apoderados</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nombre del Estudiante</th>
                                <!-- Otros encabezados de la tabla para los datos del estudiante -->
                                <!-- ... -->
                                <th>Nombre del Apoderado</th>
                                <!-- Otros encabezados de la tabla para los datos del apoderado -->
                                <!-- ... -->
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($estudiantes as $estudiante): ?>
                                <tr>
                                    <td><?= $estudiante['nombre'] ?></td>
                                    <!-- Mostrar otros datos del estudiante -->
                                    <!-- ... -->
                                    <td><?= $estudiante['nombre'] ?></td>
                                    <!-- Mostrar otros datos del apoderado -->
                                    <!-- ... -->
                                    <td>
                                        <!-- Enlaces para editar y eliminar -->
                                        <a href="<?= site_url('estudiantes/editar/' . $estudiante['estudiante_id']) ?>" class="btn btn-sm btn-primary">Editar</a>
                                        <a href="<?= site_url('estudiantes/eliminar/' . $estudiante['estudiante_id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este estudiante?')">Eliminar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include(APPPATH . 'Views/Components/toast.php'); ?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
