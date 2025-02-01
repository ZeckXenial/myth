<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
    <title>Listar Horarios</title>
    <?php include(APPPATH . 'Views/Components/headers.php'); ?>
</head>
<body>
    <?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center">Mis Horarios</h1>
        
        <!-- Selección de Curso -->
        <div class="mb-3">
            <label for="curso_id" class="lead text-center">Curso</label>
            <select class="form-select" name="curso_id" id="curso_id" required>
                <?php foreach ($cursos as $curso): ?>
                    <option value="<?= $curso['curso_id'] ?>"><?= $curso['grado'] . ' - ' . $curso['nombre_nivel'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="button" class="btn mx-auto btn-primary" data-bs-toggle="modal" data-bs-target="#crearHorarioModal">
            Agregar Horario
        </button>

        <!-- Incluir el componente del calendario -->
        <?php include(APPPATH . 'Views/Components/horario.php'); ?>
    </div>

    <!-- Modal para crear horario -->
    <div class="modal fade" id="crearHorarioModal" tabindex="-1" aria-labelledby="crearHorarioModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearHorarioModalLabel">Agregar Horario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action=<?= site_url('/horarios/crear')?> method="post">
                        <div class="mb-3">
                            <label for="profesor_id" class="form-label">Profesor</label>
                            <select class="form-select" name="profesor_id" id="profesor_id" required>
                                <option value="">Seleccione un profesor</option>
                                <?php foreach ($profesores as $profesor): ?>
                                    <option value="<?= $profesor['user_id'] ?>"><?= $profesor['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="asignatura_id" class="form-label">Asignatura</label>
                            <select class="form-select" name="asignatura_id" id="asignatura_id" required>
                                <option value="">Seleccione una asignatura</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="dia_semana" class="form-label">Día de la Semana</label>
                            <select class="form-select" name="dia_semana" required>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miércoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="hora_inicio" class="form-label">Hora Inicio</label>
                            <input type="time" class="form-control" name="hora_inicio" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora_fin" class="form-label">Hora Fin</label>
                            <input type="time" class="form-control" name="hora_fin" required>
                        </div>
                        <button type="submit" class="btn btn-success">Agregar Horario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Cargar asignaturas según el profesor seleccionado
        document.getElementById('profesor_id').addEventListener('change', function() {
            var profesorId = this.value;
            var asignaturaSelect = document.getElementById('asignatura_id');
            asignaturaSelect.innerHTML = '<option value="">Seleccione una asignatura</option>'; // Reset

            if (profesorId) {
                fetch('<?= site_url('horarios/getAsignaturasPorProfesor') ?>/' + profesorId)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(asignatura => {
                            asignaturaSelect.innerHTML += `<option value="${asignatura.asignatura_id}">${asignatura.nombre_asignatura}</option>`;
                        });
                    });
            }
        });
    </script>
</body>
</html>