
$(document).ready(function () {
    $('#usuariosTable').DataTable({"language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"} ,
        fixedColumns: true,
        scrollY: '50vh',
      
        scroller: true,
        });
    
});
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
        fixedColumns: true,
        scrollY: '50vh',
        scrollCollapse: true,
        scroller: true,
        });
});
$(document).ready(function () {
    $('#asistenciaTable').DataTable({"language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
        },
        fixedColumns: true,
        scrollY: '50vh',
        scrollCollapse: true,
        scroller: true,
        });
});
