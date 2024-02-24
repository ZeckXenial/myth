
$(document).ready(function () {
    $('#usuariosTable').DataTable({"language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"} ,
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
    
});


/* $(document).ready(function() {
    $('').DataTable({"language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        fixedColumns: true,
        scrollY: '50vh',
        scroller: true,
        });
}); */
$(document).ready(function () {
    $('#apoderadosTable').DataTable({"language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        fixedColumns: true,
        scrollY: '50vh',
        scrollCollapse: true,
        scroller: true,
        });
});
$(document).ready(function () {
    $('#estudiantesTable').DataTable({"language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
       
        scrollCollapse: true,
        fixedHeader: true,
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
            }}
        });
});
$(document).ready(function () {
    $('#asistenciaTable').DataTable({"language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        scrollY: '50vh',
        scrollCollapse: true,
        scroller: true,
        });
});
