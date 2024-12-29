<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <title>Calendario Escolar</title>
    <?php include(APPPATH . 'Views/Components/headers.php'); ?>
</head>
<body>
    <?php include(APPPATH . 'Views/Components/navbar.php'); ?>
    <div class="container">
        <h1 class="text-center">Calendario Escolar</h1>
        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">
            Agregar Evento
        </button>

        <!-- Modal de Bootstrap -->
        <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">Agregar Evento</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                    <form id="eventForm" action=<?= site_url('/calendar/addEvent')?> method="POST">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="eventTitle" name="title" placeholder="Título del evento" required>
        <label for="eventTitle">Título del evento</label>
    </div>

    <div class="form-floating mb-3">
        <select class="form-select" id="eventType" name="type" required>
            <option value="" selected>Seleccione un tipo</option>
            <option value="clase">Clase Regular</option>
            <option value="reunion">Reunión de Profesores</option>
            <option value="actividad">Actividad Extracurricular</option>
            <option value="evento">Evento Especial</option>
            <option value="festivo">Día Festivo</option>
        </select>
        <label for="eventType">Tipo de evento</label>
    </div>

    <div class="form-floating mb-3">
        <input type="datetime-local" class="form-control" id="eventStart" name="start" required>
        <label for="eventStart">Inicio del evento</label>
    </div>

    <div class="form-floating mb-3">
        <input type="datetime-local" class="form-control" id="eventEnd" name="end" required>
        <label for="eventEnd">Fin del evento</label>
    </div>

    <div class="form-floating mb-3">
        <textarea class="form-control" id="eventDescription" name="description" placeholder="Descripción del evento" style="height: 100px;" required></textarea>
        <label for="eventDescription">Descripción del evento</label>
    </div>

    <button type="submit" class="btn btn-success">Agregar Evento</button>
</form>

                    </div>
                </div>
            </div>
        </div>
        <?php include(APPPATH . 'Views/Components/calendar.php'); ?>
    </div>
    <?php include(APPPATH . 'Views/Components/toast.php'); ?>

    <?php include(APPPATH . 'Views/Components/footer.php'); ?>
</body>
</html>
