<?php include(APPPATH . 'Views/Components/headers.php'); ?>
<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
<body>
   

<div class="container mt-4">
    <h1 class="text-center">Editar Curso</h1>
    <div class="container">
        <form action="<?= site_url('cursos/update/' . $curso['curso_id']) ?>" method="post" class="form-control">
            <div class="mb-3 form-floating">
                <input type="text" class="form-control" placeholder="Nombre" id="grado" name="grado" value="<?= $curso['grado'] ?>" required>
                <label for="grado" class="form-label">Nombre</label>
            </div>
            <div class="mb-3">
        <label class="form-label">Asignaturas</label>
        <div class="mb-3 form-select form-floating" style="max-height: 100px; overflow-y: auto;">
    <?php foreach ($asignaturas as $asignatura): ?>
        <?php
        $checked = isset($asignatura['selected']) && $asignatura['selected'] ? 'checked' : '';
        ?>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="asignatura_id[]" value="<?= $asignatura['asignatura_id'] ?>" id="asignatura<?= $asignatura['asignatura_id'] ?>" <?= $checked ?>>
            <label class="form-check-label" for="asignatura<?= $asignatura['asignatura_id'] ?>">
                <?= $asignatura['nombre_asignatura'] ?>, Encargado:<?= $asignatura['nombre_usuario'] ?>
            </label>
        </div>
    <?php endforeach; ?>
</div>
</div>
            <div class="mb-3 form-floating">
                <select class="form-select" name="nivel_id" placeholder="nivel" id="nivel_id" required>
                    <?php foreach ($niveles as $nivel): ?>
                        <option value="<?= $nivel['nivel_id'] ?>" <?= ($curso['nivel_id'] == $nivel['nivel_id']) ? 'selected' : '' ?>>
                            <?= $nivel['nombre'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="nivel_id" class="form-label">Nivel</label>
            </div>
            <div class="mb-3 form-floating">
                <select class="form-select" name="user_id" id="user_id" required>
                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= $usuario['user_id'] ?>" <?= ($curso['user_id'] == $usuario['user_id']) ? 'selected' : '' ?>>
                            <?= $usuario['nombre'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <label for="user_id" class="form-label">Usuario</label>
            </div>
            <button type="submit" class="btn mx-auto btn-primary">Actualizar</button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#eliminarModal">Eliminar</button>
        </form>
    </div>
</div>

<!-- Eliminar modal -->
<div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminarModalLabel">Confirmación de eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este curso?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a id="eliminarCursoLink" href="<?= site_url('cursos/delete/' . $curso['curso_id']) ?>" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>
</body>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>