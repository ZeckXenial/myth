$(document).ready(function () {
    $('#usuariosTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        fixedHeader: true,
        scrollY: '50vh',
        responsive: true,
        scroller: true,
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Exportar',
                        autoClose: true,
                        buttons: [
                            {
                                extend: 'copy',
                                text: 'Copiar',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Print',
                                exportOptions: {
                                    margin: [0, 0, 0, 12],
                                    alignment: 'center',
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'pdf',
                                text: 'PDF',
                                exportOptions: {
                                    margin: [0, 0, 0, 12],
                                    alignment: 'center',
                                    columns: ':visible'
                                }
                            }
                        ]
                    }
                ]
            }
        }
    });

    $.fn.dataTable.ext.errMode = 'none';

/*     $(document).ready(function () {
        var exportUrl = "<?= site_url('cursos/exportar/' . $cursoId) ?>";

        // Evento para exportar todo el curso
        $('#exportarTodoCurso').click(function () {
            // Hacer una solicitud AJAX para obtener todos los datos de los estudiantes del curso
            $.ajax({
                url: "<?= site_url('cursos/exportar/') . $cursoId ?>",  // Asegúrate de pasar el cursoId desde tu vista o controlador
                method: 'GET',
                success: function(data) {
                    exportarDatosCurso(data);  // Llamamos a la función que procesa los datos
                },
                error: function() {
                    alert("Error al exportar los datos del curso.");
                }
            });
        });
    
        function exportarDatosCurso(data) {
            var table = $('<table></table>');
            var headerRow = $('<tr><th>Estudiante</th><th>Anotaciones</th><th>Asistencias</th><th>Calificaciones</th></tr>');
            table.append(headerRow);
    
            data.estudiantes.forEach(function(estudiante) {
                var row = $('<tr></tr>');
                row.append($('<td></td>').text(estudiante.nombre));
                row.append($('<td></td>').text(estudiante.anotaciones));
                row.append($('<td></td>').text(estudiante.asistencias));
                row.append($('<td></td>').text(estudiante.calificaciones));
                table.append(row);
            });
    
            table.DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
    
            table.DataTable().button('.buttons-excel').trigger();
        }
    });  */

    $('#calificacionesTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
       columns:[
      {  data:  'nombre'},
      {  data:  'calificacion'},
      {  data:  'id_alumno'},

       ],
        fixedColumns: true,
        responsive: true
    });

    $('#estudiantesTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        scrollCollapse: true,
        fixedHeader: true,
        info: false,
        responsive: true,
        scroller: true,
        layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Exportar',
                        autoClose: true,
                        columns: [
                            { data: 'nombre_estudiante' },
                            { data: 'Nombre_Apoderado' }
                        ],
                        buttons: [
                            {
                                extend: 'copy',
                                text: 'Copiar',
                                title: 'Registro de alumnos',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Print',
                                title: 'Registro de alumnos',
                                exportOptions: {
                                    margin: [0, 0, 0, 12],
                                    alignment: 'center',
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'pdf',
                                text: 'PDF',
                                title: 'Registro de alumnos',
                                exportOptions: {
                                    margin: [0, 0, 0, 12],
                                    alignment: 'center',
                                    columns: ':visible'
                                }
                            }
                        ]
                    }
                ]
            }
        }
    });

    $('#asistenciaTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        responsive: true
    });
});
