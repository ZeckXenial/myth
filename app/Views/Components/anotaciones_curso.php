<?php include(APPPATH . 'Views/Components/headers.php');?>
<?php include(APPPATH . 'Views/Components/NavBar.php');?>

<div class="container mt-4">
    <h1 class="text-center">Anotaciones de Curso</h1>
    <div class="row">
        <?php foreach ($estudiantes as $estudiante): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $estudiante['nombre_estudiante'] ?></h5>
                        <p class="card-text">Fecha de Nacimiento: <?= $estudiante['fecha_nacimiento'] ?></p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verAnotacionesModal<?= $estudiante['estudiante_id'] ?>">
                            Ver Anotaciones
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearAnotacionesModal<?= $estudiante['estudiante_id'] ?>">
                            Crear Anotaciones
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="verAnotacionesModal<?= $estudiante['estudiante_id'] ?>" tabindex="-1" aria-labelledby="verAnotacionesModalLabel<?= $estudiante['estudiante_id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verAnotacionesModalLabel<?= $estudiante['estudiante_id'] ?>">Anotaciones de <?= $estudiante['nombre_estudiante'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php if (isset($estudiante['anotaciones'])): ?>
                                <?php foreach ($estudiante['anotaciones'] as $anotacion): ?>
                                    <?php if ($anotacion['origen_anot'] === 'negativa'): ?>
                                        <div class="alert alert-danger" role="alert">
                                    <?php else: ?>
                                        <div class="alert alert-info" role="alert">
                                    <?php endif; ?>
                                        <?= $anotacion['glosa_anot'] ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-warning" role="alert">
                                    Este estudiante no tiene anotaciones.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="crearAnotacionesModal<?= $estudiante['estudiante_id'] ?>" tabindex="-1" aria-labelledby="crearAnotacionesModalLabel<?= $estudiante['estudiante_id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="CrearAnotacionesModalLabel<?= $estudiante['estudiante_id'] ?>">Anotaciones de <?= $estudiante['nombre_estudiante'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?= site_url('anotaciones/crear') ?>" method="post">
                                <input type="hidden" name="estudiante_id" value="<?= $estudiante['estudiante_id'] ?>">
                                <input type="hidden" name="user_id" value="<?= session()->get('iduser') ?>">
                                <div class="mb-3">
                                    <label for="glosa" class="form-label">Nueva Anotación:</label>
                                    <textarea class="form-control" name="glosa" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="origen_anotacion" class="form-label">Origen de la Anotación:</label>
                                    <select class="form-select" name="origen_anotacion" required>
                                        <option value="positiva">Positiva</option>
                                        <option value="negativa">Negativa</option>
                                    </select>
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
