<?php include(APPPATH . 'Views/Components/headers.php'); ?>
<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>

<body class="container">
    <h1 class="text-center">Libro de Calificaciones</h1>
    <div id="tableContainer">
        <table id="calificacionesTable" class="table datatable table-hover table-responsive table-striped table-bordered">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <!-- Las columnas de evaluaciones se agregarán dinámicamente -->
                </tr>
            </thead>
            <tbody>
                <!-- Las filas se agregarán dinámicamente aquí -->
            </tbody>
        </table>
        <button id="agregarEvaluacion" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarEvaluacion">Agregar Evaluación</button>
    </div>

    <!-- Modal para agregar evaluación -->
    <div class="modal fade" id="modalAgregarEvaluacion" tabindex="-1" aria-labelledby="modalAgregarEvaluacionLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarEvaluacionLabel">Agregar Evaluación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="formAgregarEvaluacion" action="<?= site_url('evaluaciones/agregarEvaluacion') ?>" method="POST">
    <div class="mb-3">
        <label for="numeroEvaluacion" class="form-label">Número de Evaluación</label>
        <input type="number" class="form-control" id="numeroEvaluacion" name="numero_evaluacion" required>
    </div>
    <div class="mb-3">
        <label for="fechaEvaluacion" class="form-label">Fecha de Evaluación</label>
        <input type="date" class="form-control" id="fechaEvaluacion" name="fecha_evaluacion" required>
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Semestre</label>
        <select class="form-select" id="semestre" name="semestre" required>
            <option value="1°">Primer semestre</option>
            <option value="2°">Segundo Semestre</option>
            <option value="3°">Especial</option>
        </select>
    </div>

    <input type="hidden" id="asignaturaId" name="asignatura_id" value="<?= session()->get('asignatura_id') ?? 0 ?>">
    <input type="hidden" id="cursoId" name="curso_id" value="<?= $estudiantes[0]['curso_id'] ?? 0 ?>">
    
    <button type="submit" class="btn btn-primary">Guardar Evaluación</button>
</form>
                </div>
            </div>
        </div>
    </div>

    <div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11;"></div>
</body>
<script>
$(document).ready(function() {
    // Inicializar DataTables
    var table = $('#calificacionesTable').DataTable({
        "responsive": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
        },
        "processing": true,
        "serverSide": false,
        "order": [[1, 'asc']]
    });

    // Cargar datos de estudiantes, evaluaciones y calificaciones
    $.ajax({
        url: '<?= site_url("calificaciones/obtenerCalificaciones/" . $parametrostable['0'].'/'.$parametrostable['1'] ) ?>',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            const estudiantes = response.estudiantes;
            const evaluaciones = response.evaluaciones;
            const calificaciones = response.calificaciones;

            // Construir el encabezado de la tabla con las evaluaciones
            const thead = $('#calificacionesTable thead tr');
            evaluaciones.forEach(function(evaluacion) {
                thead.append(`<th>Evaluación ${evaluacion.numero_evaluacion}</th>`);
            });

            // Organizar las calificaciones para fácil acceso
            const calificacionesMap = {};
            calificaciones.forEach(calificacion => {
                calificacionesMap[`${calificacion.estudiante_id}_${calificacion.evaluacion_id}`] = calificacion.nota;
            });

            // Limpiar el cuerpo de la tabla
            const tbody = $('#calificacionesTable tbody');
            tbody.empty();

            // Construir las filas para cada estudiante
            estudiantes.forEach(function(estudiante) {
                let fila = `<tr>
                    <td>${estudiante.nombre_estudiante}</td>`;

                evaluaciones.forEach(function(evaluacion) {
                    const calificacionKey = `${estudiante.estudiante_id}_${evaluacion.evaluacion_id}`;
                    const nota = calificacionesMap[calificacionKey] || '';
                    fila += `<td class="editable" contenteditable="true" data-id="${estudiante.estudiante_id}" data-evaluacion="${evaluacion.evaluacion_id}">
                                ${nota}
                              </td>`;
                });

                fila += `</tr>`;
                tbody.append(fila);
            });

            table.rows.add(tbody.find('tr')).draw();
        },
        error: function() {
            console.error('Error al cargar los datos de calificaciones.');
        }
    });
    $(document).on('input', '.editable', function(event) {
    let value = event.target.innerText.replace(/[^0-9]/g, ''); // Solo permitir números

    if (value.length > 1) {
        // Formato: X.Y manteniendo el orden original
        value = value.slice(0, 1) + '.' + value.slice(1);
    }

    event.target.innerText = value;  // Actualizar el texto de la celda
    placeCaretAtEnd(event.target);    // Colocar el cursor al final del texto
});

// Función para mantener el cursor al final de la celda
function placeCaretAtEnd(el) {
    el.focus();
    if (typeof window.getSelection != "undefined" && typeof document.createRange != "undefined") {
        let range = document.createRange();
        range.selectNodeContents(el);
        range.collapse(false);
        let sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(range);
    }
}

    // Guardar nota al perder el foco de la celda
    $(document).on('blur', '.editable', function() {
    const estudianteId = $(this).data('id');
    const evaluacionId = $(this).data('evaluacion');
    const nota = $(this).text();  // Cambiar .val() a .text() para obtener el contenido de la celda

    // Crear el formulario oculto
    const form = $('<form>', {
        action: '<?= site_url("evaluaciones/guardarNota") ?>',
        method: 'GET',
        style: 'display:none;',
        id: 'formGuardarNota'  // Asignamos un id para referenciarlo
    });

    form.append($('<input>', { type: 'hidden', name: 'estudiante_id', value: estudianteId }));
    form.append($('<input>', { type: 'hidden', name: 'asignatura_id', value: <?= session()->get('asignatura_id') ?? 0 ?> }));
    form.append($('<input>', { type: 'hidden', name: 'evaluacion_id', value: evaluacionId }));
    form.append($('<input>', { type: 'hidden', name: 'nota', value: nota }));
    
    $('body').append(form);

    // Interceptar el evento submit para evitar la recarga
    form.on('submit', function(e) {
        e.preventDefault();  // Prevenir la recarga de la página

        // Aquí puedes realizar cualquier acción adicional, como mostrar un mensaje o log
        console.log("Formulario enviado sin recargar la página.");
        
        // Enviar el formulario manualmente sin AJAX
        this.submit();
    });

    // Activar el evento submit en el formulario
    form.submit();
});
});
</script>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
<?php include(APPPATH . 'Views/Components/toast.php');?>
