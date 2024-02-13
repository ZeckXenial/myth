<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<?php include(APPPATH . 'Views/Components/headers.php');?>

<div class="container mt-4">
    <h1 class="text-center">Anotaciones de Curso</h1>
    <div class="row">
        <?php foreach ($estudiantes as $estudiante): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $estudiante['nombre'] ?></h5>
                        <p class="card-text">Fecha de Nacimiento: <?= $estudiante['fecha_nacimiento'] ?></p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#anotacionModal<?= $estudiante['estudiante_id'] ?>">
                            Agregar Anotación
                        </button>
                    </div>
                </div>
            </div>

            
            <div class="modal fade" id="anotacionModal<?= $estudiante['estudiante_id'] ?>" tabindex="-1" aria-labelledby="anotacionModalLabel<?= $estudiante['estudiante_id'] ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="anotacionModalLabel<?= $estudiante['estudiante_id'] ?>">Agregar Anotación para <?= $estudiante['nombre'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Aquí va el formulario para agregar la anotación -->
                            <form action="<?= site_url('anotaciones/agregar') ?>" method="post">
                                <input type="hidden" name="estudiante_id" value="<?= $estudiante['estudiante_id'] ?>">
                                <div class="mb-3">
                                    <label for="glosa" class="form-label">Glosa:</label>
                                    <textarea class="form-control" name="glosa" rows="3" required></textarea>
                                </div>
                               
                                <button type="submit" class="btn btn-primary">Agregar Anotación</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include(APPPATH . 'Views/Components/toast.php');?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
