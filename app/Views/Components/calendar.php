<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Escolar</title>

    <!-- FullCalendar CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
   
</head>
<body>
    <!-- Modal de Edición -->
    <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editEventModalLabel">Gestionar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="editEventForm">
                        <div class="mb-3">
                            <label for="editEventTitle" class="form-label">Título</label>
                            <input type="text" class="form-control" id="editEventTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEventStart" class="form-label">Inicio</label>
                            <input type="datetime-local" class="form-control" id="editEventStart" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEventEnd" class="form-label">Fin</label>
                            <input type="datetime-local" class="form-control" id="editEventEnd">
                        </div>
                        <input type="hidden" id="editEventId">
                        <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
                    </form>
                    <button id="deleteEventButton" class="btn btn-danger mt-2 w-100">Eliminar Evento</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '<?= site_url("calendar/getEvents") ?>',
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
                editable: true,
                selectable: true,
                eventClick: function(info) {
                    document.getElementById('editEventTitle').value = info.event.title;
                    document.getElementById('editEventStart').value = info.event.start.toISOString().slice(0, 16);
                    document.getElementById('editEventEnd').value = info.event.end ? info.event.end.toISOString().slice(0, 16) : '';
                    document.getElementById('editEventId').value = info.event.id;

                    var editModal = new bootstrap.Modal(document.getElementById('editEventModal'));
                    editModal.show();

                    document.getElementById('deleteEventButton').onclick = function() {
                        if (confirm("¿Deseas eliminar este evento?")) {
                            fetch(`<?= site_url("calendar/deleteEvent") ?>/${info.event.id}`, { method: 'DELETE' })
                            .then(response => {
                                if (response.ok) {
                                    info.event.remove();
                                    editModal.hide();
                                }
                            });
                        }
                    };

                    document.getElementById('editEventForm').onsubmit = function(e) {
                        e.preventDefault();
                        var title = document.getElementById('editEventTitle').value;
                        var start = document.getElementById('editEventStart').value;
                        var end = document.getElementById('editEventEnd').value;
                        var id = document.getElementById('editEventId').value;

                        fetch(`<?= site_url("calendar/editEvent") ?>/${id}`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ id: id, title: title, start: start, end: end })
                        }).then(response => response.json()).then(data => {
                            if (data.success) {
                                info.event.setProp('title', title);
                                info.event.setStart(start);
                                info.event.setEnd(end);
                                editModal.hide();
                            }
                        });
                    };
                }
            });
            calendar.render();
        });
    </script>

</body>
</html>
