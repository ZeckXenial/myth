<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<?php include(APPPATH . 'Views/Components/headers.php');?>

<div class="container mt-4">
    <h1 class="text-center">Cursos</h1>

    <div class="row">
        <?php foreach ($cursos as $curso): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text"><?= $curso['grado'] ?></p>
                        <p class="card-text">Profesor Designado: <?= $curso['nombre_usuario'] ?></p>
                        <?php $links = [
                            'Anotaciones' => "anotaciones/curso/{$curso['curso_id']}",
                            'Asistencias' => "asistencias/curso/{$curso['curso_id']}",
                            'Calificaciones' => "calificaciones/curso/{$curso['curso_id']}",
                            'Editar' => "editar/curso/{$curso['curso_id']}"
                        ]; ?>
                        <?php foreach ($links as $text => $url): ?>
                            <a href="<?= site_url($url) ?>" class="btn btn-primary"><?= $text ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Nuevo card para crear nuevo curso -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Crear Nuevo Curso</h5>
                    <a href="<?= site_url('crear_curso') ?>" class="btn btn-primary">Crear</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(APPPATH . 'Views/Components/toast.php'); ?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
