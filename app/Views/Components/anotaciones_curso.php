<?php include(APPPATH . 'Views/Components/headers.php'); ?>
<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>

<div class="container mt-4">
    <h1 class="text-center mb-4">Anotaciones de Curso</h1>
    <div class="row">
        <?php foreach ($estudiantes as $estudiante): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= $estudiante['nombre_estudiante'] ?></h5>
                        <p class="card-text">Fecha de Nacimiento: <?= $estudiante['fecha_nacimiento'] ?></p>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#verAnotacionesModal<?= $estudiante['estudiante_id'] ?>">
                                <i class="bi bi-eye"></i> Ver Anotaciones
                            </button>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#crearAnotacionesModal<?= $estudiante['estudiante_id'] ?>">
                                <i class="bi bi-pencil-square"></i> Crear Anotaciones
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ver Anotaciones Modal -->
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
                                    <div class="alert <?= $anotacion['origen_anot'] === 'negativa' ? 'alert-danger' : 'alert-info' ?>" role="alert">
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

            <!-- Crear Anotaciones Modal -->
            <div class="modal fade" id="crearAnotacionesModal<?= $estudiante['estudiante_id'] ?>" tabindex="-1" aria-labelledby="crearAnotacionesModalLabel<?= $estudiante['estudiante_id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="crearAnotacionesModalLabel<?= $estudiante['estudiante_id'] ?>">Crear Anotaci車n para <?= $estudiante['nombre_estudiante'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="<?= site_url('anotaciones/crear') ?>" method="post">
                                <input type="hidden" name="estudiante_id" value="<?= $estudiante['estudiante_id'] ?>">
                                <input type="hidden" name="fecha_anotacion" value="<?= date('Y-m-d') ?>">
                                <input type="hidden" name="user_id" value="<?= session()->get('iduser') ?>">
                                <input type="hidden" name="curso_id" value="<?= request()->uri->getsegment(3,0) ?>">

                                <!-- Glosa -->
                                <div class="mb-3">
                                    <label for="glosa" class="form-label">Nueva Anotaci車n:</label>
                                    <textarea class="form-control" name="glosa" rows="3" required></textarea>
                                </div>

                                <!-- Origen de la Anotaci車n -->
                                <div class="mb-3">
                                    <label for="origen_anotacion" class="form-label">Origen de la Anotaci車n:</label>
                                    <select class="form-select" name="origen_anotacion" required>
                                        <option value="positiva">Positiva</option>
                                        <option value="negativa">Negativa</option>
                                    </select>
                                </div>

                                <!-- Grado de la Anotaci車n -->
                                <div class="mb-3">
                                    <label for="grado" class="form-label">Grado de la Anotaci車n:</label>
                                    <select class="form-select" name="grado" required>
                                        <option value="connotado">Connotaci車n negativa</option>
                                        <option value="grave">Grave</option>
                                        <option value="gravisimo">Grav赤simo</option>
                                        <option value="extremo">Extremo</option>
                                        <option value="connotado">Connotaci車n positiva</option>
                                        <option value="bueno">Bueno</option>
                                        <option value="buenisimo">Buen赤simo</option>
                                        <option value="felicitaciones">Felicitaciones</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle-fill"></i> Agregar Anotaci車n
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>

<?php include(APPPATH . 'Views/Components/toast.php'); ?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>
