<!-- cursos.php -->
<!-- app/Views/components/asistencia.php -->
<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<?php include(APPPATH . 'Views/Components/headers.php');?>

<div class="container mt-4">
    <h1 class="text-center">Cursos</h1>

    <div class="row">
        <?php foreach ($cursos as $curso): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title"><?= $curso['nombre_curso'] ?></h3>
                        <p class="card-text"><?= $curso['nivel_curso'] ?></p>
                        <a href="<?= site_url("anotaciones/curso/{$curso['id_curso']}") ?>" class="btn btn-primary">Anotaciones</a>
                        <a href="<?= site_url("asistencias/curso/{$curso['id_curso']}") ?>" class="btn btn-success">Asistencias</a>
                        <a href="<?= site_url("calificaciones/curso/{$curso['id_curso']}") ?>" class="btn btn-info">Calificaciones</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include(APPPATH . 'Views/Components/toast.php'); ?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
