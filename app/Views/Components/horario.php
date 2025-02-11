<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://cdn.jsdelivr.net/npm/rrule@2.6.4/dist/es5/rrule.min.js'></script>

    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
    <div id='calendar' class="container mt-5 form-control"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            events: function(fetchInfo, successCallback, failureCallback) {
                var cursoId = document.getElementById('curso_id').value;
                fetch(`<?= site_url('horarios/getHorariosPorCurso') ?>/${cursoId}`)
                    .then(response => response.json())
                    .then(data => {
                        const eventos = [];

                        data.forEach(event => {
                            const startDate = new Date(event.start);
                            const endDate = new Date(event.end);
                            const rruleString = event.rrule; // Asegurar que venga en formato correcto
                            
                            if (rruleString) {
                                try {
                                    const rule = RRule.fromString(rruleString);
                                    const occurrences = rule.between(fetchInfo.start, fetchInfo.end);
                                    
                                    occurrences.forEach(occurrence => {
                                        const eventEnd = new Date(occurrence.getTime() + (endDate - startDate));
                                        eventos.push({
                                            id: event.id,
                                            title: event.title,
                                            start: occurrence.toISOString(),
                                            end: eventEnd.toISOString(),
                                            description: event.description
                                        });
                                    });
                                } catch (error) {
                                    console.error('Error parsing RRule:', error);
                                }
                            } else {
                                eventos.push({
                                    id: event.id,
                                    title: event.title,
                                    start: startDate.toISOString(),
                                    end: endDate.toISOString(),
                                    description: event.description
                                });
                            }
                        });
                        successCallback(eventos);
                    })
                    .catch(error => {
                        console.error('Error fetching events:', error);
                        failureCallback(error);
                    });
            },
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día'
            },
            locale: 'es',
            eventClick: function(info) {
                // Llenar el modal de edición con los datos del evento
                var editEventTitle = document.getElementById('dia_semana');
                if (editEventTitle) editEventTitle.value = info.event.title;

                var editEventStart = document.getElementById('hora_inicio');
                if (editEventStart) editEventStart.value = info.event.start.toISOString().slice(0, 16);

                var editEventEnd = document.getElementById('hora_fin');
                if (editEventEnd) editEventEnd.value = info.event.end ? info.event.end.toISOString().slice(0, 16) : '';

                var editEventId = document.getElementById('editEventId');
                if (editEventId) editEventId.value = info.event.id; // Almacenar el ID del evento

                // Mostrar el modal de edición
                $('#editEventModal').modal('show');

                // Manejar la eliminación del evento
                var deleteEventButton = document.getElementById('deleteEventButton');
                if (deleteEventButton) {
                    deleteEventButton.onclick = function() {
                        if (confirm("¿Deseas eliminar este evento?")) {
                            fetch(`<?= site_url('horarios/eliminar') ?>/${info.event.id}`, {
                                 
                            }).then(response => {
                                if (response.ok) {
                                    info.event.remove(); // Eliminar evento del calendario
                                    $('#editEventModal').modal('hide'); // Cerrar el modal
                                }
                            });
                        }
                    };
                }

                // Manejar la edición del evento
                document.getElementById('editEventForm').onsubmit = function(e) {
                    e.preventDefault();
                    var title = document.getElementById('dia_semana').value;
                    var start = document.getElementById('hora_inicio').value;
                    var end = document.getElementById('hora_fin').value;
                    var id = document.getElementById('editEventId').value; // Obtener el ID del evento

                    // Lógica para editar el evento
                    fetch(`<?= site_url('horarios/editar') ?>/${id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ dia_semana: title, hora_inicio: start, hora_fin: end })
                    }).then(response => response.json()).then(data => {
                        if (data.success) {
                            var cursoId = document.getElementById('curso_id').value;
                            info.event.setProp('dia_semana', title);
                            info.event.setStart('hora_inicio',start);
                            info.event.setEnd('hora_fin',end);
                            calendar.removeAllEvents();
                            calendar.addEventSource('<?= site_url('horarios/getHorariosPorCurso') ?>/' + cursoId);
                            calendar.render();
                            $('#editEventModal').modal('hide'); // Cerrar el modal
                            document.getElementById('editEventForm').reset(); 
                        }
                    });
                };
            }
        });
        calendar.render();
        
        // Cargar horarios al seleccionar un curso
        document.getElementById('curso_id').addEventListener('change', function() {
            var cursoHiddenInput = document.getElementById('curso_id_hidden');
            var cursoId = this.value;
            cursoHiddenInput.value = cursoId;
            // Limpiar eventos existentes y cargar nuevos eventos
            calendar.removeAllEvents();
            calendar.addEventSource('<?= site_url('horarios/getHorariosPorCurso') ?>/' + cursoId);
            calendar.render();
        });
    });
    </script>

</body>
</html>
