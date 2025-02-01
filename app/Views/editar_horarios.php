<!-- app/Views/editar_horario.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Horario</title>
</head>
<body>
    <?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
    <div class="container mt-5">
        <h2 class="text-center">Editar Horario</h2>
        <form action="/horarios/editar/<?= $horario['horario_id'] ?>" method="post">
            <div class="mb-3">
                <label for="profesor_id" class="form-label">Profesor ID</label>
                <input type="number" class="form-control" name="profesor_id" value="<?= $horario['profesor_id'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="asignatura_id" class="form-label">Asignatura ID</label>
                <input type="number" class="form-control" name="asignatura_id" value="<?= $horario['asignatura_id'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="dia_semana" class="form-label">Día de la Semana</label>
                <select class="form-select" name="dia_semana" required>
                    <option value="Lunes" <?= $horario['dia_semana'] == 'Lunes' ? 'selected' : '' ?>>Lunes</option>
                    <option value="Martes" <?= $horario['dia_semana'] == 'Martes' ? 'selected' : '' ?>>Martes</option>
                    <option value="Miércoles" <?= $horario['dia_semana'] == 'Miércoles' ? 'selected' : '' ?>>Miércoles</option>
                    <option value="Jueves" <?= $horario['dia_semana'] == 'Jueves' ? 'selected' : '' ?>>Jueves</option>
                    <option value="Viernes" <?= $horario['dia_semana'] == 'Viernes' ? 'selected' : '' ?>>Viernes</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="hora_inicio" class="form-label">Hora Inicio</label>
                <input type="time" class="form-control" name="hora_inicio" value="<?= $horario['hora_inicio'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="hora_fin" class="form-label">Hora Fin</label>
                <input type="time" class="form-control" name="hora_fin" value="<?= $horario['hora_fin'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="anio_escolar" class="form-label">Año Escolar</label>
                <input type="number" class="form-control" name="anio_escolar" value="<?= $horario['anio_escolar'] ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Actualizar Horario</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>