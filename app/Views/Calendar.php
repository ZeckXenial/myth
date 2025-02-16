<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario Escolar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>
    <?php include(APPPATH . 'Views/Components/headers.php'); ?>
    <style>
        .container {
            max-width: 900px;
            margin: auto;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
    <div class="container">
        <div class="card shadow-lg p-4">
            <h2 class="text-center text-primary">📅 Calendario Escolar</h2>
            <div class="text-end mb-3">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#eventModal">
                    <i class="bi bi-plus-lg"></i> Agregar Evento
                </button>
            </div>
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Modal Agregar Evento -->
    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Agregar Evento</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm" action="<?= site_url('/calendar/addEvent') ?>" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="eventTitle" name="title" placeholder="Título" required>
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
                            <label for="eventStart">Inicio</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="datetime-local" class="form-control" id="eventEnd" name="end" required>
                            <label for="eventEnd">Fin</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="eventDescription" name="description" placeholder="Descripción" style="height: 100px;" required></textarea>
                            <label for="eventDescription">Descripción</label>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Guardar Evento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include(APPPATH . 'Views/Components/calendar.php'); ?>

    <?php include(APPPATH . 'Views/Components/toast.php'); ?>
    <?php include(APPPATH . 'Views/Components/footer.php'); ?>
</body>
</html>
