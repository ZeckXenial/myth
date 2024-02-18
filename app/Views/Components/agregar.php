<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>

<h1 class="text-center">Agregar Curso</h1>

<div class="container form-control">
    <form action="<?= site_url('cursos/guardar') ?>" method="post">
        <div class="mb-3">
            <label for="grado" class="form-label">Grado</label>
            <input type="text" class="form-control" id="grado" name="grado" placeholder="Ingrese el grado" required>
        </div>
        <div class="mb-3">
            <label for="nivel_id" class="form-label">Nivel</label>
            <select class="form-select" name="nivel_id" id="nivel_id" required>
                <?php foreach ($niveles as $nivel): ?>
                    <option value="<?= $nivel['nivel_id'] ?>"><?= $nivel['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="asignatura_id[]" class="form-label">Asignaturas</label>
            <select class="form-select" name="asignatura_id[]" id="asignatura_id" multiple required>
                <?php foreach ($asignaturas as $asignatura): ?>
                    <option value="<?= $asignatura['asignatura_id'] ?>"><?= $asignatura['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">Profesor Designado</label>
            <select class="form-select" name="user_id" id="user_id" required>
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['user_id'] ?>"><?= $usuario['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn mx-auto btn-primary">Agregar</button>
    </form>
</div>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
