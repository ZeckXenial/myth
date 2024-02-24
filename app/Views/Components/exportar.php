<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<body>
    

<div class="container">
    <h2 class="text-center" style="margin-top: 20px;">Exportar Informacion</h2>
    
    <div class="accordion" id="accordionExample">
    <?php foreach ($estudiantes as $estudiante): ?>
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?= $estudiante['estudiante_id'] ?>">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $estudiante['estudiante_id'] ?>" aria-expanded="true" aria-controls="collapse<?= $estudiante['estudiante_id'] ?>">
                    <?= $estudiante['nombre'] ?>
                </button>
            </h2>
            <div id="collapse<?= $estudiante['estudiante_id'] ?>" class="accordion-collapse mx-auto collapse" aria-labelledby="heading<?= $estudiante['estudiante_id'] ?>" data-bs-parent="#accordion">
                <div class="accordion-body">
                <!-- <div class="d-flex justify-content-center align-items-center">
                 <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
                </div>
          </div> -->
                    <div id="dataTableWrapper" class="datatable"  >
                        <table id="asistenciasContainer<?= $estudiante['estudiante_id'] ?>"  class="visually-hidden" ></table>
                        <table id="calificacionesContainer<?= $estudiante['estudiante_id'] ?>"  class="visually-hidden" ></table>
                        <table id="anotacionesContainer<?= $estudiante['estudiante_id'] ?>" class="visually-hidden" ></table>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
<script>
$(document).ready(function () {
    $('.accordion-collapse').on('show.bs.collapse', async function () {
        var estudianteId = $(this).attr('id').replace('collapse', '');
        
        $('.spinner-border' + estudianteId).show();
        
        try {
            const response = await fetch(`<?= site_url("cursos/exportarestudiante/") ?>${estudianteId}`);
            const data = await response.json();

            // Ocultar el spinner
            $('.spinner-border' + estudianteId).hide();
            
            // Actualizar tabla de asistencias
            var asistenciasTableHTML = '<table class="table">';
            asistenciasTableHTML += '<thead><tr><th>Fecha</th><th>Asistencia</th></tr></thead><tbody>';
            for (var i = 0; i < data.asistencias.length; i++) {
                asistenciasTableHTML += '<tr>';
                asistenciasTableHTML += '<td>' + data.asistencias[i].fecha + '</td>';
                asistenciasTableHTML += '<td>' + (data.asistencias[i].presente ? 'Presente' : 'Ausente') + '</td>';
                asistenciasTableHTML += '</tr>';
            }
            asistenciasTableHTML += '</tbody></table>';
            $('#asistenciasContainer' + estudianteId).html(asistenciasTableHTML);

            // Actualizar tabla de calificaciones
            var calificacionesTableHTML = '<table class="table">';
            calificacionesTableHTML += '<thead><tr><th>Nota</th></tr></thead><tbody>';
            for (var i = 0; i < data.calificaciones.length; i++) {
                calificacionesTableHTML += '<tr>';
                calificacionesTableHTML += '<td>' + data.calificaciones[i].nota + '</td>';
                calificacionesTableHTML += '</tr>';
            }
            calificacionesTableHTML += '</tbody></table>';
            $('#calificacionesContainer' + estudianteId).html(calificacionesTableHTML);

            // Actualizar tabla de anotaciones
            var anotacionesTableHTML = '<table class="table">';
            anotacionesTableHTML += '<thead><tr><th>Origen</th><th>Glosa</th></tr></thead><tbody>';
            for (var i = 0; i < data.anotaciones.length; i++) {
                anotacionesTableHTML += '<tr>';
                anotacionesTableHTML += '<td>' + data.anotaciones[i].origen_anot + '</td>';
                anotacionesTableHTML += '<td>' + data.anotaciones[i].glosa_anot + '</td>';
                anotacionesTableHTML += '</tr>';
            }
            anotacionesTableHTML += '</tbody></table>';
            $('#anotacionesContainer' + estudianteId).html(anotacionesTableHTML);

            // Agregar los botones de DataTables a sus respectivas tablas
            $.fn.dataTable.ext.errMode = 'none';
            $('#asistenciasContainer' + estudianteId).DataTable({
                ordering: false,
                info:     false,
                searching: false,
                paging: false,
                layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Asistencias',
                        autoClose: true,
                        title:     'Historial de asistencias',
                        buttons: [
                            {
                                extend: 'copy',
                                text: 'Copiar',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
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

            $('#calificacionesContainer' + estudianteId).DataTable({
                searching: false,
                paging: false,
                ordering: false,
                info:     false,
                layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Resumen de notas',
                        autoClose: true,
                        title:     'Resumen de Notas',
                        buttons: [
                            {
                                extend: 'copy',
                                text: 'Copiar',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
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

            $('#anotacionesContainer' + estudianteId).DataTable({
                searching: false,
                paging: false,
                ordering: false,
                info:     false,
                layout: {
            topStart: {
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Anotaciones ',
                        autoClose: true,
                        buttons: [
                            {
                                extend: 'copy',
                                text: 'Copiar',
                                title:     'Anotaciones del estudiante',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
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
        } catch (error) {
            // Error handling
            $('#spinner' + estudianteId).hide();
            console.error(error);
        }
    });
});

</script>
</body>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
