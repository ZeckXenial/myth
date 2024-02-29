<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<body class="container">
    <h1 class="text-center">Editar Asignatura</h1>
    <form class="form-control" action="<?= site_url('asignaturas/editar/' . $asignatura['asignatura_id']) ?>" method="post">
        <div class="mb-3">
            <label for="nombre_asignatura" class="form-label">Nombre de la Asignatura:</label>
            <input type="text" id="nombre_asignatura" name="nombre_asignatura" class="form-control" value="<?= $asignatura['nombre'] ?>">
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">Selecciona al usuario principal:</label><br>
            <select id="user_id" name="user_id" class="form-select">
                <?php foreach ($usuarios as $usuario): ?>
                    <option value="<?= $usuario['user_id'] ?>" <?php if ($usuario['user_id'] == $asignatura['user_id']) echo 'selected' ?>><?= $usuario['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <input type="submit" value="Guardar Cambios" class="btn btn-primary">
    </form>
</body>
<?php include(APPPATH . 'Views/Components/footer.php');?>
