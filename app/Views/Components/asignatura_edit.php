<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<body class="container">
    <h1 class="text-center">Editar Asignatura</h1>
    <form class="form-control" action="<?= site_url('asignaturas/editar/' . $asignatura['asignatura_id']) ?>" method="post">
        <div class="mb-3">
            <label for="nombre_asignatura" class="form-label">Nombre de la Asignatura:</label>
            <input type="text" id="nombre_asignatura" name="nombre_asignatura" class="form-control" value="<?= $asignatura['nombre_asignatura'] ?>">
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">Selecciona al profesor principal:</label><br>
            <select id="user_id" name="user_id" class="form-select">
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['user_id'] ?>" <?php if ($usuario['user_id'] == $asignatura['user_id']) echo 'selected' ?>><?= $usuario['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="submit" value="Guardar Cambios" class="btn btn-primary">
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmacionEliminar">Eliminar</button>
    </form>

    <!-- Modal de confirmación de eliminación -->
    <div class="modal fade" id="confirmacionEliminar" tabindex="-1" aria-labelledby="confirmacionEliminarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmacionEliminarLabel">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea eliminar esta asignatura?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <!-- Formulario que enviará la solicitud de eliminación al controlador -->
                    <form id="formEliminarAsignatura" action="<?= site_url('asignaturas/eliminar/' . $asignatura['asignatura_id']) ?>" method="post">
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include(APPPATH . 'Views/Components/footer.php');?>
