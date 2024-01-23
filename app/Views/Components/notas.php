<?php include(APPPATH . 'Views/Components/NavBar.php');?>
<?php include(APPPATH . 'Views/Components/headers.php');?>
<div class="container">
        <h2>Cursos Disponibles</h2>

        <!-- Mostrar cards de cursos -->
        <?php foreach ($cursos as $curso): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?= $curso['nombre_curso'] ?></h5>
                    <p class="card-text">Descripción del curso o información adicional.</p>
                    <!-- Enlace al CRUD del curso -->
                    <a href="<?= site_url('notas/crud/' . $curso['id_curso']) ?>" class="btn btn-primary">Editar Notas</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php include(APPPATH . 'Views/Components/toast.php');?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>