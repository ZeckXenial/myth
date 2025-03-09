<div id='calendar' class="container mt-5 form-control"></div>
<script>
  // Función para convertir el JSON de rrule a un objeto compatible con FullCalendar RRule
  function convertirRrule(rruleJson) {
    try {
      if (!rruleJson) return null;
      const rruleObj = JSON.parse(rruleJson);
      if (!rruleObj.dtstart) return null;
      
      // Aseguramos que dtstart esté en formato ISO
      rruleObj.dtstart = new Date(rruleObj.dtstart).toISOString();
      
      // Convertir freq a minúsculas (p.ej., "WEEKLY" -> "weekly")
      if (rruleObj.freq) {
        rruleObj.freq = rruleObj.freq.toLowerCase();
      }
      
      // Renombrar 'byday' a 'byweekday'
      if (rruleObj.byday) {
        rruleObj.byweekday = rruleObj.byday;
        delete rruleObj.byday;
      }
      
      // Convertir byhour y byminute a números, si están definidos
      if (rruleObj.byhour) {
        rruleObj.byhour = parseInt(rruleObj.byhour, 10);
      }
      if (rruleObj.byminute) {
        rruleObj.byminute = parseInt(rruleObj.byminute, 10);
      }
      
      return rruleObj;
    } catch (error) {
      console.error("Error al convertir RRule:", error);
      return null;
    }
  }

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
              // Calcular la duración a partir de start y end
              const startDate = new Date(event.start);
              const endDate = new Date(event.end);
              const durationMs = endDate - startDate;
              const totalMinutes = Math.floor(durationMs / 60000);
              const hours = Math.floor(totalMinutes / 60);
              const minutes = totalMinutes % 60;
              const durationStr = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}`;

              if (event.rrule && event.rrule !== "null") {
                const rruleObj = convertirRrule(event.rrule);
                if (rruleObj) {
                  eventos.push({
                    id: event.id,
                    title: event.title,
                    rrule: rruleObj,  // Se pasa el objeto directamente
                    duration: durationStr,
                    description: event.description
                  });
                }
              } else {
                eventos.push({
                  id: event.id,
                  title: event.title,
                  start: event.start,
                  end: event.end,
                  description: event.description
                });
              }
            });
            successCallback(eventos);
          })
          .catch(error => {
            console.error('Error al obtener eventos:', error);
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
        document.getElementById('dia_semana').value = info.event.title;
        document.getElementById('hora_inicio').value = info.event.start ? info.event.start.toISOString().slice(0, 16) : '';
        document.getElementById('hora_fin').value = info.event.end ? info.event.end.toISOString().slice(0, 16) : '';
        document.getElementById('editEventId').value = info.event.id;

        $('#editEventModal').modal('show');

        document.getElementById('deleteEventButton').onclick = function() {
          if (confirm("¿Deseas eliminar este evento?")) {
            fetch(`<?= site_url('horarios/eliminar') ?>/${info.event.id}`, {
              
            }).then(response => {
              if (response.ok) {
                info.event.remove();
                $('#editEventModal').modal('hide');
              }
            });
          }
        };

        document.getElementById('editEventForm').onsubmit = function(e) {
          e.preventDefault();
          var title = document.getElementById('dia_semana').value;
          var start = document.getElementById('hora_inicio').value;
          var end = document.getElementById('hora_fin').value;
          var id = document.getElementById('editEventId').value;

          fetch(`<?= site_url('horarios/editar') ?>/${id}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ dia_semana: title, hora_inicio: start, hora_fin: end })
          }).then(response => response.json()).then(data => {
            if (data.success) {
              info.event.setProp('title', title);
              info.event.setStart(start);
              info.event.setEnd(end);
              calendar.refetchEvents();
              $('#editEventModal').modal('hide');
              document.getElementById('editEventForm').reset();
            }
          });
        };
      }
    });

    calendar.render();

    document.getElementById('curso_id').addEventListener('change', function() {
      document.getElementById('curso_id_hidden').value = this.value;
      calendar.refetchEvents();
    });
  });
</script>
