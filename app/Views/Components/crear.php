<?php include(APPPATH . 'Views/Components/headers.php'); ?>
<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>

<body>
    <div class="container">
        <h1 class="text-center mb-4">Crear Nueva Asignatura</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-control p-4">
                    <?= form_open('asignaturas/crear') ?>

                    <!-- Nombre de la asignatura -->
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nombre_asignatura" name="nombre_asignatura" placeholder="Nombre de la asignatura" required>
                        <label for="nombre_asignatura">Nombre de la Asignatura</label>
                    </div>

                    <!-- Selección de profesor -->
                    <div class="form-floating mb-3">
                        <select class="form-select" id="usuarios" name="user_id" required>
                            <option value="" disabled selected>Selecciona un profesor</option>
                            <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?= $usuario['user_id'] ?>"><?= $usuario['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="usuarios">Profesor Principal</label>
                    </div>

                    <!-- Selección de curso -->
                    <div class="form-floating mb-3">
                        <select class="form-select" id="cursos" name="curso_id" required>
                            <option value="" disabled selected>Selecciona un curso</option>
                            <?php foreach ($cursos as $curso): ?>
                                <option value="<?= $curso['curso_id'] ?>"><?= $curso['grado'] ?> - <?= $curso['nombre_nivel'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="cursos">Curso</label>
                    </div>

                    <!-- Botón de submit -->
                    <div class="d-flex justify-content-center">
                        <input type="submit" value="Crear Asignatura" class="btn btn-primary">
                    </div>

                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>

    <?php include(APPPATH . 'Views/Components/toast.php'); ?>
</body>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
