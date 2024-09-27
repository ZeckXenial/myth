$(document).ready(function () {
    // Manejo de la exportación por estudiante
    $('.accordion-collapse').on('show.bs.collapse', async function () {
        var estudianteId = $(this).attr('id').replace('collapse', '');
        const spinnerElement = $('.spinner-border');
        spinnerElement.show();
        
        try {
            const response = await fetch(`<?= site_url("cursos/exportarestudiante/") ?>${estudianteId}`);
            const data = await response.json();

            spinnerElement.hide("fast", "swing");

            // Actualizar tabla de asistencias
            var asistenciasTableHTML = '<table class="table">';
            asistenciasTableHTML += '<thead class="text-center"><tr><th>Fecha</th><th>Asistencia</th></tr></thead><tbody>';
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
            calificacionesTableHTML += '<thead><tr><th>Asignatura</th><th>Notas</th></tr></thead><tbody>';
            
            // Objeto para almacenar temporalmente las notas por asignatura
            var notasPorAsignatura = {};
            
            // Recorre los datos de calificaciones para agrupar las notas por asignatura
            for (var i = 0; i < data.calificaciones.length; i++) {
                var nota = data.calificaciones[i];
                if (!(nota.nombre_asignatura in notasPorAsignatura)) {
                    notasPorAsignatura[nota.nombre_asignatura] = [];
                }
                notasPorAsignatura[nota.nombre_asignatura].push(nota.nota);
            }

            for (var asignatura in notasPorAsignatura) {
                calificacionesTableHTML += '<tr>';
                calificacionesTableHTML += '<td>' + asignatura + '</td>';
                calificacionesTableHTML += '<td>' + notasPorAsignatura[asignatura].join(' ') + '</td>';
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

            // Agregar botones de exportación a las tablas (asistencias, calificaciones, anotaciones)
            initializeDataTable('#asistenciasContainer' + estudianteId, 'Historial de asistencias', '/myth/public/logo-css-180x181.png');
            initializeDataTable('#calificacionesContainer' + estudianteId, 'Resumen de Notas', '/myth/public/logo-css-180x181.png');
            initializeDataTable('#anotacionesContainer' + estudianteId, 'Anotaciones del estudiante', '/myth/public/logo-css-180x181.png');

        } catch (error) {
            spinnerElement.hide();
            console.error(error);
        }
    });

    $('#exportarTodoCurso').on('click', async function () {
        const urlParams = new URLSearchParams(window.location.search);
        const cursoId = urlParams.get('cursoId');        console.log(cursoId);
        const spinnerElement = $('.spinner-border');
        spinnerElement.show();
        
        try {
            const response = await fetch(`<?= site_url("cursos/exportarcurso/") ?>${cursoId}`);
            const data = await response.json();
            spinnerElement.hide();
            var cursoAsistenciasHTML = '<table class="table">';
            cursoAsistenciasHTML += '<thead><tr><th>Fecha</th><th>Asistencias Totales</th></tr></thead><tbody>';
            for (var i = 0; i < data.asistencias.length; i++) {
                cursoAsistenciasHTML += '<tr>';
                cursoAsistenciasHTML += '<td>' + data.asistencias[i].fecha + '</td>';
                cursoAsistenciasHTML += '<td>' + data.asistencias[i].total_asistencias + '</td>';
                cursoAsistenciasHTML += '</tr>';
            }
            cursoAsistenciasHTML += '</tbody></table>';
            $('#asistenciasCursoContainer').html(cursoAsistenciasHTML);

            initializeDataTable('#asistenciasCursoContainer', 'Historial de asistencias del curso', '/myth/public/logo-css-180x181.png');

        } catch (error) {
            spinnerElement.hide();
            console.error(error);
        }
    });
    function initializeDataTable(selector, title, logoPath) {
        $(selector).DataTable({
            ordering: false,
            info: false,
            searching: false,
            paging: false,
            layout: {
                topStart: {
                    buttons: [
                        {
                            extend: 'collection',
                            text: title,
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
                                    extend: 'excel',
                                    text: 'Excel',
                                    exportOptions: {
                                        columns: ':visible'
                                    }
                                },
                                {
                                    extend: 'pdf',
                                    text: 'PDF',
                                    title: title,
                                    download: 'open',
                                    customize: function (doc) {
                                        var logoDataURL = getBase64Image(logoPath);
                                        doc.content.splice(1, 0, {
                                            margin: [0, 0, 0, 12],
                                            alignment: 'center',
                                            image: logoDataURL
                                        });
                                    }
                                }
                            ]
                        }
                    ]
                }
            }
        });
    }

    function getBase64Image(imgUrl) {
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext("2d");
        var img = new Image();
        img.src = imgUrl;
        canvas.width = img.width;
        canvas.height = img.height;
        ctx.drawImage(img, 0, 0);
        return canvas.toDataURL("image/png");
    }
});
