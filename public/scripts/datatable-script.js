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
