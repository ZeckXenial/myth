<div class="container mt-4">
    <h2>Lista de Cursos</h2>

    <div class="row mt-4">
        <?php foreach ($cursos as $curso): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $curso['nombre_curso']; ?></h5>
                        <p class="card-text">Cantidad de Estudiantes: <?= $curso['cantidadEstudiantes']; ?></p>
                        <a href="<?= site_url('curso/detalles/' . $curso['id_curso']) ?>" class="btn btn-primary">Ver Detalles</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
