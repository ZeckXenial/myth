<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<h1 class="text-center">Editar Curso</h1>
<div class="container form-control">

    <form action="<?= site_url('cursos/update/' . $curso['curso_id']) ?>" method="post">
        <div class="mb-3">
            <label for="grado" class="form-label">Grado</label>
            <input type="text" class="form-control" id="grado" name="grado" value="<?= $curso['grado'] ?>" required>
        </div>
        <div class="mb-3">
            <label for="asignatura_id" class="form-label">Asignatura</label>
            <select class="form-select" name="asignatura_id" id="asignatura_id" required>
                <?php foreach ($asignaturas as $asignatura): ?>
                    <option value="<?= $asignatura['asignatura_id'] ?>" <?= ($curso['asignatura_id'] == $asignatura['asignatura_id']) ? 'selected' : '' ?>>
                        <?= $asignatura['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">Usuario</label>
            <select class="form-select" name="user_id" id="user_id" required>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['user_id'] ?>" <?= ($curso['user_id'] == $usuario['user_id']) ? 'selected' : '' ?>>
                        <?= $usuario['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="nivel_id" class="form-label">Nivel</label>
            <select class="form-select" name="nivel_id" id="nivel_id" required>
                <?php foreach ($niveles as $nivel): ?>
                    <option value="<?= $nivel['nivel_id'] ?>" <?= ($curso['nivel_id'] == $nivel['nivel_id']) ? 'selected' : '' ?>>
                        <?= $nivel['nombre'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="asignaturas" class="form-label">Asignaturas</label>
            <select class="form-select" name="asignatura_id[]" id="asignaturas" multiple required>
                <?php if (isset($curso['asignaturas'])): ?>
                    <?php foreach ($curso['asignaturas'] as $asignatura): ?>
                        <option value="<?= $asignatura['asignatura_id'] ?>" <?= (in_array($asignatura['asignatura_id'], $curso['asignaturas'])) ? 'selected' : '' ?>>
                            <?= $asignatura['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">No hay asignaturas disponibles</option>
                <?php endif; ?>
            </select>
        </div>
        <button type="submit" class="btn mx-auto btn-primary">Actualizar</button>
    </form>
</div>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
