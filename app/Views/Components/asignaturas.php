<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>

<h1 class="text-center">Calificaciones por Asignatura</h1>

<div class="container mt-4">
    <div class="row">
        <?php foreach ($asignaturas as $asignatura): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $asignatura['nombre'] ?></h5>
                        <a href="<?= site_url('calificaciones/' . $asignatura['asignatura_id']) ?>" class="btn btn-primary">Entrar a Calificaciones</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
