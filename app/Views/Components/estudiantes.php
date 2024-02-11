<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<?php include(APPPATH . 'Views/Components/headers.php');?>

<div class="container mt-4">
    <h1 class="text-center">Gestión de Estudiantes y Apoderados</h1>

    <div class="row">
        <div class="col-md-6">
            <!-- Formulario para agregar nuevo estudiante -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Agregar Estudiante</h5>
                    <form action="<?= site_url('estudiantes/agregar') ?>" method="post">
                        <div class="form-group">
                            <label for="nombre_estudiante">Nombre</label>
                            <input type="text" class="form-control" id="nombre_estudiante" name="nombre_estudiante" placeholder="Nombre del estudiante">
                        </div>
                        <!-- Otros campos del estudiante (fecha de nacimiento, grado, etc.) -->
                        <!-- ... -->
                        <button type="submit" class="btn btn-primary">Agregar Estudiante</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <!-- Formulario para agregar nuevo apoderado -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Agregar Apoderado</h5>
                    <form action="<?= site_url('apoderados/agregar') ?>" method="post">
                        <div class="form-group">
                            <label for="nombre_apoderado">Nombre</label>
                            <input type="text" class="form-control" id="nombre_apoderado" name="nombre_apoderado" placeholder="Nombre del apoderado">
                        </div>
                        <!-- Otros campos del apoderado (teléfono, correo electrónico, etc.) -->
                        <!-- ... -->
                        <button type="submit" class="btn btn-primary">Agregar Apoderado</button>
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
                                    <td><?= $estudiante['nombre_apoderado'] ?></td>
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
