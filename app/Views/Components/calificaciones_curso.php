<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>

<?php
function calcularColspan($calificaciones)
{
    $colspan = 0;

    foreach ($calificaciones as $calificacion) {
        if (isset($calificacion['nota'])) {
            $colspan++;
        }
    }

    return $colspan;
}
?>

<body class="container">
    <h1 class="text-center">Libro de Calificaciones</h1>
    <div id="tableContainer">
        <table id="calificacionesTable"  class="table datatable table-hover table-responsive table-striped table-bordered">
            <thead>
                <tr>
                    <th data-field="estudiante">Estudiante</th>
                    <th data-field="notas" colspan="<?= calcularColspan($calificaciones) ?>">Notas</th>
                </tr>
            </thead>
            <tbody>
            
            <?php $index = 0; ?>
            <?php foreach ($estudiantes as $estudiante): ?>
                <tr>
                    <td><?= $estudiante['nombre_estudiante'] ?></td>
                    <?php foreach ($calificaciones as $calificacion): ?>
                        <?php $calificacionId = isset($calificacion['calificacion_id']) ? $calificacion['calificacion_id'] : null; ?>
                        <?php $nota = isset($calificacion['nota']) ? $calificacion['nota'] : ''; ?>
                        <?php $nombreCalificacion = isset($calificacion['nombre_estudiante']) ? $calificacion['nombre_estudiante'] : ''; ?>
                        <?php if ($estudiante['nombre_estudiante'] === $nombreCalificacion): ?>
                            <td id="cell_<?= $index ?>_<?= $calificacionId ?>" class="editable" data-id="<?= $calificacionId ?>" contenteditable="true"><?= $nota ?></td>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tr>
                <?php $index++; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button id="agregarColumna" class="btn btn-primary">Agregar Columna</button>
        <button id="guardarCambios" class="btn btn-success" style="display: none;">Guardar Cambios</button>
    </div>

</body>
<script>
    
    $(document).ready(function() {
        $('#calificacionesTable').on('keypress', '.editable', function (event) {
                var charCode = (event.which) ? event.which : event.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46) {
                    event.preventDefault();
                }
            });
        $('#calificacionesTable').on('input', '.editable', function() {
            $('#guardarCambios').fadeIn(200);
        });
        $('#guardarCambios').on('click', function() {
            var cursoId = <?= $estudiantes[0]['curso_id'] ?? null; ?>;
            var asignaturaId = <?= session()->get('asignatura_id') ?? null; ?>;
            var data = obtenerDatosTabla();
            console.log(data);
            $.ajax({
                url: '<?= site_url("calificaciones/guardar") ?>',
                method: 'POST',
                data: {
                    data: data,
                    curso_id: cursoId,
                    asignatura_id: asignaturaId
                },
                success: function(response) {
                    console.log(response);
                    $('#guardarCambios').hide();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });


    function obtenerDatosTabla() {
    var data = [];
    $('#calificacionesTable tbody tr').each(function() {
        var idEstudiante = $(this).find('td:first').text().trim();
        var estudiante = <?= json_encode($estudiantes) ?>.find(function(est) {
            return est.nombre_estudiante === idEstudiante;
        });
        var estudianteId = estudiante ? estudiante.estudiante_id : null;

        $(this).find('td').each(function(index, cell) {
            if (index > 0) { 
                var nota = $(cell).text().trim();
                var calificacionId = $(cell).data('id'); 
                var row = {
                    id_estudiante: estudianteId,
                    nota: nota !== '' ? nota : null, 
                    calificacion_id: calificacionId 
                };
                if (row['id_estudiante']) {
                    data.push(row);
                }
            }
        });
    });
    return JSON.stringify(data);
}

function agregarFila() {
        var newRow = '<tr>';
        newRow += '<td contenteditable="true"></td>';
        newRow += '<td class="editable" data-id="" contenteditable="true"></td>';
        newRow += '</tr>';
        $('#calificacionesTable tbody').append(newRow);
    }

    $('#agregarColumna').on('click', function() {
        $('#calificacionesTable thead tr').append('<th data-editable="true" data-field="Nueva Nota">Nueva Nota</th>');
        $('#calificacionesTable tbody tr').each(function() {
            $(this).append('<td class="editable" data-id="" contenteditable="true"></td>');
        });
    });
    });
</script>
<?php include(APPPATH . 'Views/Components/footer.php');?>
<?php include(APPPATH . 'Views/Components/toast.php');?>
