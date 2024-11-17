$(document).ready(function () {
    $('.accordion-collapse').on('show.bs.collapse', async function () {
        var estudianteId = $(this).attr('id').replace('collapse', '');
        const spinnerElement = $('.spinner-border');
        spinnerElement.show();
        
        try {
            const response = await fetch(`<?= site_url("cursos/exportarestudiante/") ?>${estudianteId}`);
            const data = await response.json();

            
           spinnerElement.hide("fast","swing");
            
            // Actualizar tabla de asistencias
            var asistenciasTableHTML = '<table class="table">';
            asistenciasTableHTML += '<thead class="text-center"><tr><th>Fecha</th><th>Asistencia</th></tr></thead><tbody ';
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
                // Si la asignatura aún no está en el objeto, inicialízala
                if (!(nota.nombre_asignatura in notasPorAsignatura)) {
                    notasPorAsignatura[nota.nombre_asignatura] = [];
                }
                // Agrega la nota al arreglo de la asignatura correspondiente
                notasPorAsignatura[nota.nombre_asignatura].push(nota.nota);
            }
            
            // Recorre el objeto con las notas por asignatura para crear las filas de la tabla
            for (var asignatura in notasPorAsignatura) {
                calificacionesTableHTML += '<tr>';
                calificacionesTableHTML += '<td>' + asignatura + '</td>';
                calificacionesTableHTML += '<td>' + notasPorAsignatura[asignatura].join('   ') + '</td>';
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
            function getBase64Image(imgUrl) {
                var canvas = document.createElement("canvas");
                var ctx = canvas.getContext("2d");
                var img = new Image();
                img.src = imgUrl;
                canvas.width = img.width;
                canvas.height = img.height;
                ctx.drawImage(img, 0, 0);
                var dataURL = canvas.toDataURL("image/png");
                return dataURL;
            }
            getBase64Image('/myth/public/logo-css-180x181.png');

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
                                title:     'Historial de asistencias',
                                download: 'open',
                                customize: function (doc) {
                                    var logoDataURL = getBase64Image('/myth/public/logo-css-180x181.png');
                                    doc.content.splice(1, 0, {
                                        margin: [0, 0, 0, 12],
                                        alignment: 'center',
                                        image: logoDataURL                               });
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
                                title:     'Resumen de Notas',
                                download: 'open',
                                customize: function (doc) {
                                    var logoDataURL = getBase64Image('/myth/public/logo-css-180x181.png');
                                    doc.content.splice(1, 0, {
                                        margin: [0, 0, 0, 12],
                                        alignment: 'center',
                                        image: logoDataURL                               });
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
                               
                            },
                            {
                                extend: 'pdf',
                                text: 'PDF',
                                title:     'Anotaciones del estudiante',
                                download: 'open',
                                customize: function (doc) {
                                    var logoDataURL = getBase64Image('/myth/public/logo-css-180x181.png');
                                    doc.content.splice(1, 0, {
                                        margin: [0, 0, 0, 12],
                                        alignment: 'center',
                                        image: logoDataURL                               });
                                }
                                
                            }
                        ]
                    }
                ]
            }
        }
            });
        } catch (error) {
            $('.spinner-border').hide();
            console.error(error);
        }
        
    });
    $('#exportarTodoCurso').on('click', async function () {
        var cursoId = $(this).val();  // Obtener el valor
        const spinnerElement = $('.spinner-border');
        spinnerElement.show();
        
        
        // Hacer la petición al servidor para obtener los datos del curso
        const response = await fetch(`<?= site_url("cursos/exportarcurso/") ?>${cursoId}`);
        const data = await response.json();
        console.log(data);
            
            spinnerElement.hide("fast", "swing");
            
            // Llenar las tablas con los datos recibidos
            // Asistencias
            let asistenciasTableHTML = '<table class="table">';
            asistenciasTableHTML += '<thead class="text-center"><tr><th>Fecha</th><th>Asistencia</th></tr></thead><tbody>';
            for (let i = 0; i < data.asistencias.length; i++) {
                asistenciasTableHTML += '<tr>';
                asistenciasTableHTML += `<td>${data.asistencias[i].fecha}</td>`;
                asistenciasTableHTML += `<td>${data.asistencias[i].presente ? 'Presente' : 'Ausente'}</td>`;
                asistenciasTableHTML += '</tr>';
            }
            asistenciasTableHTML += '</tbody></table>';
            $('#asistenciasContainer').html(asistenciasTableHTML);

            // Calificaciones
            let calificacionesTableHTML = '<table class="table">';
            calificacionesTableHTML += '<thead><tr><th>Asignatura</th><th>Notas</th></tr></thead><tbody>';
            let notasPorAsignatura = {};
            for (let i = 0; i < data.calificaciones.length; i++) {
                const nota = data.calificaciones[i];
                if (!(nota.nombre_asignatura in notasPorAsignatura)) {
                    notasPorAsignatura[nota.nombre_asignatura] = [];
                }
                notasPorAsignatura[nota.nombre_asignatura].push(nota.nota);
            }
            for (let asignatura in notasPorAsignatura) {
                calificacionesTableHTML += '<tr>';
                calificacionesTableHTML += `<td>${asignatura}</td>`;
                calificacionesTableHTML += `<td>${notasPorAsignatura[asignatura].join('   ')}</td>`;
                calificacionesTableHTML += '</tr>';
            }
            calificacionesTableHTML += '</tbody></table>';
            $('#calificacionesContainer').html(calificacionesTableHTML);

            // Anotaciones
            let anotacionesTableHTML = '<table class="table">';
            anotacionesTableHTML += '<thead><tr><th>Origen</th><th>Glosa</th></tr></thead><tbody>';
            for (let i = 0; i < data.anotaciones.length; i++) {
                anotacionesTableHTML += '<tr>';
                anotacionesTableHTML += `<td>${data.anotaciones[i].origen_anot}</td>`;
                anotacionesTableHTML += `<td>${data.anotaciones[i].glosa_anot}</td>`;
                anotacionesTableHTML += '</tr>';
            }
            anotacionesTableHTML += '</tbody></table>';
            $('#anotacionesContainer').html(anotacionesTableHTML);

            // Inicializar DataTables para cada sección
            $('#asistenciasContainer').DataTable({
                searching: false,
                paging: false,
                ordering: false,
                info: false,
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Asistencias',
                        buttons: [
                            { extend: 'copy', text: 'Copiar' },
                            { extend: 'excel', text: 'Excel' },
                            { extend: 'pdf', text: 'PDF' }
                        ]
                    }
                ]
            });

            $('#calificacionesContainer').DataTable({
                searching: false,
                paging: false,
                ordering: false,
                info: false,
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Resumen de Notas',
                        buttons: [
                            { extend: 'copy', text: 'Copiar' },
                            { extend: 'excel', text: 'Excel' },
                            { extend: 'pdf', text: 'PDF' }
                        ]
                    }
                ]
            });

            $('#anotacionesContainer').DataTable({
                searching: false,
                paging: false,
                ordering: false,
                info: false,
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Anotaciones',
                        buttons: [
                            { extend: 'copy', text: 'Copiar' },
                            { extend: 'excel', text: 'Excel' },
                            { extend: 'pdf', text: 'PDF' }
                        ]
                    }
                ]
            });

      
    });

});
