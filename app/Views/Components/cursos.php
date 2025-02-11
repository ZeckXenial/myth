<?php include(APPPATH . 'Views/Components/headers.php'); ?>

<body>
    <?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
    <div class="container mt-4">
        <h1 class="text-center mb-4">Cursos Disponibles</h1>

        <div class="row">
            <?php foreach ($cursos as $curso): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?= $curso['grado'] ?></h5>
                            <p class="card-text text-muted">Nivel: <span class="fw-bold"><?= $curso['nombre_nivel'] ?></span></p>
                            <p class="card-text">Profesor: <span class="fw-bold"><?= $curso['nombre_usuario'] ?></span></p>
                            <hr>
                            <div class="d-grid gap-2">
                                <a href="<?= site_url("anotaciones/curso/{$curso['curso_id']}") ?>" class="btn btn-outline-primary">📋 Anotaciones</a>
                                <a href="<?= site_url("asistencias/curso/{$curso['curso_id']}") ?>" class="btn btn-outline-success">📅 Asistencias</a>
                                <a href="<?= site_url("calificaciones/asignaturas/{$curso['curso_id']}") ?>" class="btn btn-outline-warning">📊 Calificaciones</a>
                                <?php if ((session()->get('idrol') === '2' || session()->get('idrol') === '3')): ?>
                                    <a href="<?= site_url("cursos/editar/{$curso['curso_id']}") ?>" class="btn btn-outline-info">✏️ Editar</a>
                                <?php endif; ?>
                                <a href="<?= site_url("cursos/exportar/{$curso['curso_id']}");?>" class="btn btn-outline-secondary">📤 Exportar</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <?php if ((session()->get('idrol') === '2' || session()->get('idrol') === '3')): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">➕ Crear Asignatura</h5>
                            <a href="<?= site_url('asignaturas/agregar') ?>" class="btn btn-primary w-100">Nueva Asignatura</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-lg rounded-4">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bold">➕ Crear Curso</h5>
                            <a href="<?= site_url('cursos/agregar') ?>" class="btn btn-success w-100">Nuevo Curso</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include(APPPATH . 'Views/Components/toast.php'); ?>
</body>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
