// datatable-script.js
$(document).ready(function () {
    $('#usuariosTable').DataTable();
});
$(document).ready(function () {
    $('#apoderadosTable').DataTable();
});
$(document).ready(function () {
    $('#asistenciaTable').DataTable();
});
// assets/js/calificacionesDataTable.js

$(document).ready(function() {
    var table = $('#calificacionesTable').DataTable({
        // Configuraciones de DataTables
        // ...

        // Añade una fila inicialmente
        initComplete: function () {
            agregarFila();
        }
    });

    // Función para agregar una nueva fila
    function agregarFila() {
        var newRow = table.row.add([
            'Nombre del estudiante',
            'Nombre de la materia',
            '<input type="text" class="form-control nota-input editable" />',
            '<button class="btn btn-primary btn-agregar-fila">Agregar Nota</button>'
        ]).draw();

        // Asigna un manejador de eventos al botón de la nueva fila
        $(newRow.node()).find('.btn-agregar-fila').on('click', function() {
            // Obtén los datos de la nueva fila
            var rowData = table.row($(this).parents('tr')).data();
            var nombreEstudiante = rowData[0];
            var nombreMateria = rowData[1];
            var nuevaNota = $(this).parents('tr').find('.nota-input').val();

            // Aquí puedes realizar acciones adicionales si es necesario

            // Agrega la nueva fila con los datos actualizados
            agregarFila();
        });

        // Asigna un manejador de eventos al campo de entrada de texto de la nueva fila
        $(newRow.node()).find('.nota-input').on('blur', function () {
            actualizarNota($(this));
        });
    }

    function actualizarNota(elemento) {
        var cell = table.cell(elemento);
        var idCalificacion = elemento.data('id');
        var nuevaNota = elemento.val();

        // Verificar si el valor ha cambiado
        if (cell.data() !== nuevaNota) {
            // Actualizar la celda en la DataTable
            cell.data(nuevaNota);

            // Realizar una llamada AJAX para guardar la nueva nota en la base de datos
            $.ajax({
                url: '/calificaciones/actualizar', // Reemplaza con la URL de tu controlador o servicio
                type: 'POST',
                data: {
                    id_calificacion: idCalificacion,
                    nueva_nota: nuevaNota
                },
                success: function (response) {
                    // Manejar la respuesta del servidor si es necesario
                    console.log(response);
                },
                error: function (error) {
                    // Manejar errores si es necesario
                    console.error(error);
                }
            });
        }
    }

    // Asigna un manejador de eventos a todos los campos de entrada de texto con la clase 'editable'
    $('#calificacionesTable').on('blur', '.editable', function () {
        actualizarNota($(this));
    });
});

