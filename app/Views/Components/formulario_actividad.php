<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
<?php include(APPPATH . 'Views/Components/headers.php'); ?>

<body>
    <div class="container mt-4">
        <div class="card shadow-sm p-4">
            <h1 class="text-center mb-4">Registra tu actividad diaria</h1>
            <form action="<?= site_url('actividad/registrarActividad') ?>" method="post">
                
                <input type="hidden" name="curso_id" value="<?= esc($curso['curso_id']) ?>">
                <input type="hidden" name="asignatura_id" value="<?= esc($asignatura['asignatura_id']) ?>">
                
                <div class="form-floating mb-3">
                    <textarea class="form-control" name="glosa" placeholder="Descripción de la actividad" 
                        <?= $actividadRegistrada ? 'disabled' : '' ?> required>
                        <?= $actividadRegistrada ? esc($glosaExistente) : '' ?>
                    </textarea>
                    <label for="glosa">Descripción de la actividad</label>
                </div>
                
                <?php if ($actividadRegistrada): ?>
                    <div class="alert alert-info text-start">
                        <small><strong>Responsable de la actividad de hoy:</strong> <?= esc($nombreResponsable) ?></small>
                    </div>
                <?php endif; ?>
                
                <div class="text-center">
                    <button class="btn btn-primary" type="submit" <?= $actividadRegistrada ? 'disabled' : '' ?>>Registrar actividad</button>
                </div>
            </form>
        </div>
    </div>
</body>

<?php include(APPPATH . 'Views/Components/toast.php'); ?>
<?php include(APPPATH . 'Views/Components/footer.php'); ?>