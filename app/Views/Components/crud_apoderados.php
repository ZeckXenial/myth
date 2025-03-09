<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
<?php include(APPPATH . 'Views/Components/headers.php'); ?>

<body class="container mt-5">
    <h2 class="text-center mb-4" style="margin-top: 25px;">Editar Información de Matrícula</h2>
    <div class="form-control p-4 shadow-sm rounded">
        <!-- Formulario para Editar Matrícula -->
        <form action="<?= site_url('matriculas/actualizar/' .$estudiante_id.'/'.$apoderado_id. '/'.$matricula_id); ?>" method="post">
            <div class="mb-3 form-floating">
                <input type="text" name="nombre_estudiante" class="form-control" id="nombre_estudiante" value="<?= $matricula->nombre_estudiante; ?>" required>
                <label for="nombre_estudiante">Nombre del Estudiante</label>
            </div>
            <div class="mb-3 form-floating">
                <input type="date" name="fecha_nacimiento" class="form-control" id="fecha_nacimiento" value="<?= $matricula->fecha_nacimiento; ?>" required>
                <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            </div>
            <div class="mb-3 form-floating">
                <select name="curso_id" class="form-select" id="curso_id" required>
                    <option value="">Seleccione un curso</option>
                    <?php foreach ($cursos as $curso): ?>
                        <option value="<?= esc($curso['curso_id']); ?>" <?= esc($curso['curso_id']) == $matricula->curso_id ? 'selected' : ''; ?>>
                            <?= esc($curso['grado']) . ' - ' . esc($curso['nombre_nivel']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="curso_id">Curso</label>
            </div> 
            <div class="mb-3 form-floating">
                <input type="text" name="nombre_apoderado" class="form-control" id="nombre_apoderado" value="<?= $matricula->nombre_apoderado; ?>" required>
                <label for="nombre_apoderado">Nombre del Apoderado</label>
            </div>
            <div class="mb-3 form-floating">
                <input type="text" name="numero_telefono" class="form-control" id="numero_telefono" value="<?= $matricula->numero_telefono; ?>" required>
                <label for="numero_telefono">Teléfono del Apoderado</label>
            </div>
            <div class="mb-3 form-floating">
                <input type="email" name="email" class="form-control" id="email" value="<?= $matricula->email; ?>" required>
                <label for="email">Email del Apoderado</label>
            </div>
            <div class="form-floating mb-3">
                <select name="estado" class="form-select" required>
                    <option value="Matriculado">Matriculado</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Anulado">Anulado</option>
                </select>
                <label for="estado">Estado</label>
            </div>
            <div class="mb-3 form-floating">
                <input type="text" name="rut_estudiante" class="form-control" id="rut_estudiante" value="<?= $matricula->rut_estudiantes; ?>" required>
                <label for="rut_estudiante">RUT del Estudiante</label>
            </div>
            <div class="mb-3 form-floating">
                <input type="text" name="rut_apoderado" class="form-control" id="rut_apoderado" value="<?= $matricula->rut_apoderado; ?>" required>
                <label for="rut_apoderado">RUT del apoderado</label>
            </div>
            <div class="mb-3 form-floating">
                <input type="number" name="numero_matricula" class="form-control" id="numero_matricula" value="<?= $matricula->nmatricula; ?>" placeholder="">
                <label for="numero_matricula">Número de Matrícula</label>
            </div>
            <div class="mb-3 form-floating">
                <input type="date" name="fecha_matricula" class="form-control" id="fecha_matriculacion" value="<?= $matricula->fecha_matriculacion; ?>" required>
                <label for="fecha_matriculacion">Fecha de Matriculación</label>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>

<script>
    document.getElementById('rut_estudiante').addEventListener('input', function(event) {
        let value = event.target.value.replace(/[^0-9]/g, ''); // Eliminar cualquier carácter que no sea número
        if (value.length > 8) {
            value = value.slice(0, 8) + '-' + value.slice(8);
        }
        event.target.value = value;
    });

    document.getElementById('rut_apoderado').addEventListener('input', function(event) {
        let value = event.target.value.replace(/[^0-9]/g, ''); // Eliminar cualquier carácter que no sea número
        if (value.length > 8) {
            value = value.slice(0, 8) + '-' + value.slice(8);
        }
        event.target.value = value;
    });
</script>

<?php include(APPPATH . 'Views/Components/toast.php'); ?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
</body>
