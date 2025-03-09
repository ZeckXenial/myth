<?php include(APPPATH . 'Views/Components/headers.php'); ?>
<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>

<body>
    <h1 class="text-center mb-4">Calificaciones por Asignatura</h1>

    <div class="container mt-4">
        <div class="row">
            <?php foreach ($asignaturas as $asignatura): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $asignatura['nombre_asignatura'] ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Profesor: <?= $asignatura['nombre'] ?></h6>

                            <!-- Botones de acci車n -->
                            <div class="d-grid gap-2">
                                <!-- Bot車n para acceder a las calificaciones -->
                                <a href="<?= site_url('calificaciones/' . $asignatura['curso_id'] . '/' . $asignatura['asignatura_id']) ?>" class="btn btn-primary">Entrar a Calificaciones</a>
                                
                                <!-- Bot車n para registro de actividades -->
                                <a href="<?= site_url('actividad/formulario/' . $asignatura['curso_id'] . '/' . $asignatura['asignatura_id']) ?>" class="btn btn-primary">Registro de Actividades</a>
                                <a href="<?= site_url('actividad/vista/' . $asignatura['curso_id'] . '/' . $asignatura['asignatura_id']) ?>" class="btn btn-primary">Ver Actividades</a>

                                <!-- Bot車n para editar (visible solo para ciertos roles) -->
                                <?php if (session()->get('idrol') === '2' || session()->get('idrol') === '3'): ?>
                                    <a href="<?= site_url('editar/' . $asignatura['asignatura_id']) ?>" class="btn btn-secondary">Editar</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
