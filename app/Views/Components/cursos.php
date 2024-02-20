<?php include(APPPATH . 'Views/Components/headers.php');?>


<body>
    <?php include(APPPATH . 'Views/Components/NavBar.php');?>
<div class="container mt-4">
    <h1 class="text-center">Cursos</h1>

    <div class="row">
        <?php foreach ($cursos as $curso): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text"><?= $curso['grado'] ?></p>
                        <p class="card-text">Nivel: <?= $curso['nombre_nivel'] ?></p> <!-- Agregamos el nivel aquí -->
                        <p class="card-text">Profesor Designado: <?= $curso['nombre_usuario'] ?></p>
                        <?php $links = [
                            'Anotaciones' => "anotaciones/curso/{$curso['curso_id']}",
                            'Asistencias' => "asistencias/curso/{$curso['curso_id']}",
                            'Calificaciones' => "calificaciones/asignaturas/{$curso['curso_id']}",
                            'Editar' => "cursos/editar/{$curso['curso_id']}"
                        ]; ?>
                        <?php foreach ($links as $text => $url): ?>
                            <a href="<?= site_url($url) ?>" class="btn btn-primary"><?= $text ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Crear Nuevo Curso</h5>
                    <a href="<?= site_url('cursos/agregar') ?>" class="btn btn-primary">Crear</a>
                </div>
            </div>
        </div>
    </div>
</div>    
<?php include(APPPATH . 'Views/Components/toast.php'); ?>
</body>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
