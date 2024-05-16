<!-- asistencias_curso.php -->
<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<?php include(APPPATH . 'Views/Components/headers.php');?>

<h1>Asistencias</h1>

<div class="row">
    <?php foreach ($asistencias as $asistencia): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $asistencia['nombre_estudiante'] ?></h5>
                    <p class="card-text">Fecha: <?= $asistencia['fecha_asistencia'] ?></p>
                    <p class="card-text">Asistió: <?= $asistencia['asistio'] ? 'Sí' : 'No' ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include(APPPATH . 'Views/Components/toast.php'); ?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
