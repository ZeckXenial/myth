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
            getBase64Image('<?= base_url()?>public/logo-css-180x181.png');
            getBase64Image('<?= base_url()?>public/logo-css-180x181.png');

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
                                    var logoDataURL = getBase64Image('<?= base_url('public/logo-css-180x181.png') ?>');
                                    doc.content.splice(1, 0, {
                                        margin: [0, 0, 0, 12],
                                        alignment: 'center',
                                        image: logoDataURL
                                    });
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
                                    var logoDataURL = getBase64Image('<?= base_url()?>public/logo-css-180x181.png');
                                    var logoDataURL = getBase64Image('<?= base_url()?>public/logo-css-180x181.png');
                                    doc.content.splice(1, 0, {
                                        margin: [0, 0, 0, 12],
                                        alignment: 'center',
                                        image: logoDataURL
                                    });
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
                                    var logoDataURL = getBase64Image('<?= base_url('public/logo-css-180x-181.png') ?>');
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
        } catch (error) {
            $('.spinner-border').hide();
            console.error(error);
        }
        
    });
    $('#exportarTodoCurso').on('click', async function () {
        var cursoId = $(this).val();
        const spinnerElement = $('.spinner-border');
        spinnerElement.show();
    
        try {
            // Hacer la petición al servidor
            const response = await fetch(`<?= site_url("cursos/exportarcurso/") ?>${cursoId}`);
            const rawData = await response.json();
            spinnerElement.hide();
    
            if (!Array.isArray(rawData) || rawData.length === 0) {
                alert('No hay datos disponibles para generar el PDF.');
                return;
            }
    
            // Agrupar datos por estudiante
            const estudiantes = {};
            rawData.forEach(item => {
                const nombre = item.nombre_estudiante || 'Desconocido';
                if (!estudiantes[nombre]) {
                    estudiantes[nombre] = {
                        asistencias: [],
                        calificaciones: [],
                        anotaciones: []
                    };
                }
    
                estudiantes[nombre].asistencias.push({
                    fecha: item.fecha_asistencia || 'N/A',
                    presente: item.presente === "1" ? "Presente" : "Ausente"
                });
    
                estudiantes[nombre].calificaciones.push({
                    asignatura: item.nombre_asignatura || 'N/A',
                    nota: item.nota !== null ? item.nota : 'Sin nota'
                });
    
                estudiantes[nombre].anotaciones.push({
                    origen: item.origen_anot || 'N/A',
                    glosa: item.glosa_anot || 'N/A'
                });
            });
    
            // Generar contenido del PDF
            let pdfContent = [
                {
                    text: 'Reporte del Curso',
                    style: 'header',
                    alignment: 'center'
                },
                { text: `Fecha: ${new Date().toLocaleDateString()}`, alignment: 'right', margin: [0, 0, 0, 10] }
            ];
    
            Object.keys(estudiantes).forEach(nombre => {
                const { asistencias, calificaciones, anotaciones } = estudiantes[nombre];
    
                pdfContent.push(
                    { text: `Estudiante: ${nombre}`, style: 'subheader', margin: [0, 20, 0, 10] },
                    { text: 'Asistencias', style: 'subheader', margin: [0, 10, 0, 10] },
                    {
                        table: {
                            widths: ['*', '*'],
                            body: [
                                [{ text: 'Fecha', bold: true }, { text: 'Asistencia', bold: true }],
                                ...asistencias.map(asistencia => [asistencia.fecha, asistencia.presente])
                            ]
                        },
                        layout: 'lightHorizontalLines'
                    },
                    { text: 'Calificaciones', style: 'subheader', margin: [0, 20, 0, 10] },
                    {
                        table: {
                            widths: ['*', '*'],
                            body: [
                                [{ text: 'Asignatura', bold: true }, { text: 'Nota', bold: true }],
                                ...calificaciones.map(calificacion => [calificacion.asignatura, calificacion.nota])
                            ]
                        },
                        layout: 'lightHorizontalLines'
                    },
                    { text: 'Anotaciones', style: 'subheader', margin: [0, 20, 0, 10] },
                    {
                        table: {
                            widths: ['*', '*'],
                            body: [
                                [{ text: 'Origen', bold: true }, { text: 'Glosa', bold: true }],
                                ...anotaciones.map(anotacion => [anotacion.origen, anotacion.glosa])
                            ]
                        },
                        layout: 'lightHorizontalLines'
                    }
                );
            });
    
            const docDefinition = {
                content: pdfContent,
                styles: {
                    header: { fontSize: 18, bold: true },
                    subheader: { fontSize: 14, bold: true }
                },
                defaultStyle: {
                    fontSize: 10
                }
            };
    
            pdfMake.createPdf(docDefinition).download(`Reporte_Curso_${cursoId}.pdf`);
        } catch (error) {
            console.error('Error al generar el PDF:', error);
            spinnerElement.hide();
            alert('Ocurrió un error al generar el PDF.');
        }
    });
    
    $('#exportarasistencia').on('click', async function () {
        const spinnerElement = $('.spinner-border');
        spinnerElement.show();
    
        try {
            // Hacer la petición al servidor
            const response = await fetch(`<?= site_url("cursos/exportarasistencias/") ?>${cursoId}`);
            const rawData = await response.json();
            spinnerElement.hide();
    
            if (!rawData.success) {
                alert(rawData.message);
                return;
            }
    
            const pdfData = rawData.pdf_data;
    
            // Generar contenido del PDF
            let pdfContent = [
                { text: 'Reporte de Asistencias', style: 'header', alignment: 'center' }
            ];
    
            pdfData.body.forEach(item => {
                // Verificar si el item es un título de curso/mes
                if (item[0].startsWith('Curso:')) {
                    pdfContent.push({ text: item[0], style: 'subheader', margin: [0, 10, 0, 5] });
                    pdfContent.push({ text: item[1], style: 'subheader', margin: [0, 0, 0, 20] });
                } else {
                    // Agregar asistencia al cuerpo
                    pdfContent.push({
                        table: {
                            body: [
                                [{ text: 'Fecha', bold: true }, { text: 'Estudiante', bold: true }, { text: 'Asistencia', bold: true }],
                                [item[2], item[3], item[4]]
                            ]
                        },
                        layout: 'lightHorizontalLines'
                    });
                }
            });
    
            // Definir el documento PDF
            const docDefinition = {
                content: pdfContent,
                styles: {
                    header: { fontSize: 18, bold: true },
                    subheader: { fontSize: 14, bold: true }
                }
            };
    
            // Descargar el PDF
            pdfMake.createPdf(docDefinition).download('Reporte_Asistencias.pdf');
        } catch (error) {
            console.error('Error al generar el PDF:', error);
            spinnerElement.hide();
            alert('Ocurrió un error al generar el PDF.');
        }
    });
    

});
