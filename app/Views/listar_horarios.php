<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include(APPPATH . 'Views/Components/headers.php'); ?>
    <title>Horarios</title>
</head>
<body>
    <?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
    <div class="container mt-5">
        <h1 class="text-center mx-auto">Mis Horarios</h1>
        
        <!-- Selección de Curso -->
        <div class="mb-3">
            <label for="curso_id" class="lead text-center">Curso</label>
            <select class="form-select" name="curso_id" id="curso_id" required>
                <option value="" disabled selected>Seleccione un curso</option> 
                <?php foreach ($cursos as $curso): ?>
                    <option value="<?= $curso['curso_id'] ?>"><?= $curso['grado'] . ' - ' . $curso['nombre_nivel'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
                
        <?php if ($_SESSION['role'] === 'Director'): ?>
            <!-- Se deshabilita el botón hasta que se seleccione un curso -->
            <button type="button" id="btnAgregarHorario" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearHorarioModal" disabled>
                <i class="bi bi-calendar-plus"></i> Agregar Horario
            </button>
        <?php endif; ?>
        
        <div class="mx-auto" style="margin-top: 20px;">
            <?php include(APPPATH . 'Views/Components/horario.php'); ?>
        </div>
       
    </div>
    
    <!-- Modal de Edición Mejorado -->
    <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editEventModalLabel">
                        <i class="bi bi-pencil-square"></i> Editar Horario
                    </h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="editEventForm">
                        <div class="form-floating mb-3">
                            <select class="form-select" name="dia_semana" id="dia_semana" required>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miércoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                            </select>
                            <label for="dia_semana">Día de la Semana</label>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" required>
                                    <label for="hora_inicio">Hora de Inicio</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="time" class="form-control" name="hora_fin" id="hora_fin" required>
                                    <label for="hora_fin">Hora de Fin</label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="editEventId">
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <?php if ($_SESSION['role'] === 'Director'): ?>
                        <button id="deleteEventButton" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                        <button type="submit" class="btn btn-success" form="editEventForm">
                            <i class="bi bi-save"></i> Guardar Cambios
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Crear -->
    <div class="modal fade" id="crearHorarioModal" tabindex="-1" aria-labelledby="crearHorarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="crearHorarioModalLabel">Agregar Horario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= site_url('/horarios/crear') ?>" method="post">
                        <!-- El valor del curso seleccionado se asigna aquí -->
                        <input type="hidden" name="curso_id" id="curso_id_hidden" value="">
                        <div class="form-floating mb-3">
                            <select class="form-select" name="profesor_id" id="profesor_id" required>
                                <option value="" disabled selected>Seleccione un profesor</option>
                                <?php foreach ($profesores as $profesor): ?>
                                    <option value="<?= $profesor['user_id'] ?>"><?= $profesor['nombre'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="profesor_id">Profesor</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" name="asignatura_id" id="asignatura_id" required>
                                <option value="" disabled selected>Seleccione una asignatura</option>
                            </select>
                            <label for="asignatura_id">Asignatura</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" name="dia_semana" id="dia_semana" required>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miércoles">Miércoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>
                            </select>
                            <label for="dia_semana">Día de la Semana</label>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="hora_inicio"><i class="bi bi-clock"></i></label>
                                    <input type="time" class="form-control" name="hora_inicio" id="hora_inicio" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="hora_fin"><i class="bi bi-clock"></i></label>
                                    <input type="time" class="form-control" name="hora_fin" id="hora_fin" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" name="recurrencia" id="recurrencia">
                                <option value="ninguna" selected>Sin repetición</option>
                                <option value="semanal">Semanal</option>
                                <option value="mensual">Mensual</option>
                            </select>
                            <label for="recurrencia">Recurrencia</label>
                        </div>
                        <input type="hidden" name="rrule" id="rruleField">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-calendar-plus"></i> Agregar Horario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts existentes y nuevos scripts para el manejo del curso -->
    <script>
        // Actualiza las asignaturas en función del profesor seleccionado
        document.getElementById('profesor_id').addEventListener('change', function() {
            var profesorId = this.value; // Obtener el ID del profesor seleccionado
            var asignaturaSelect = document.getElementById('asignatura_id');
            asignaturaSelect.innerHTML = '<option value="">Seleccione una asignatura</option>'; // Reset

            if (profesorId) {
                fetch('<?= site_url('horarios/getAsignaturasPorProfesor') ?>/' + profesorId)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(asignatura => {
                            asignaturaSelect.innerHTML += `<option value="${asignatura.asignatura_id}">${asignatura.nombre_asignatura}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error('Error al cargar las asignaturas:', error);
                    });
            }
        });

        // Control de la recurrencia para construir el RRule
        document.getElementById('recurrencia').addEventListener('change', function () {
            const recurrencia = this.value;
            const diaSemana = document.getElementById('dia_semana').value;
            const horaInicio = document.querySelector('#crearHorarioModal #hora_inicio').value;
            if (!horaInicio) {
                alert('Por favor, ingrese una hora de inicio válida.');
                return;
            }

            const horaParts = horaInicio.split(':');
            const hora = horaParts[0] || '00';
            const minuto = horaParts[1] || '00';
            
            let rrule = '';

            if (recurrencia === 'semanal') {
                const dayMap = {
                    'Lunes': 'MO',
                    'Martes': 'TU',
                    'Miércoles': 'WE',
                    'Jueves': 'TH',
                    'Viernes': 'FR'
                };
                rrule = `FREQ=WEEKLY;BYDAY=${dayMap[diaSemana]};BYHOUR=${hora};BYMINUTE=${minuto}`;
            } else if (recurrencia === 'mensual') {
                rrule = `FREQ=MONTHLY;BYMONTHDAY=${new Date().getDate()};BYHOUR=${hora};BYMINUTE=${minuto}`;
            } else {
                rrule = 'FREQ=DAILY';  
            }

            document.getElementById('rruleField').value = rrule;
        });

        // Evitar crear un horario sin haber seleccionado un curso
        document.getElementById('curso_id').addEventListener('change', function() {
            var cursoSeleccionado = this.value;
            var btnAgregarHorario = document.getElementById('btnAgregarHorario');
            var cursoHidden = document.getElementById('curso_id_hidden');
            
            if (cursoSeleccionado) {
                // Habilitamos el botón y asignamos el curso seleccionado al input oculto
                btnAgregarHorario.disabled = false;
                cursoHidden.value = cursoSeleccionado;
            } else {
                btnAgregarHorario.disabled = true;
                cursoHidden.value = '';
            }
        });
    </script>
</body>
</html>
