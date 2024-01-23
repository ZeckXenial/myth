<!-- app/Views/directive/establecimientos.php -->
<?php include(APPPATH . 'Views/Components/NavBar.php'); ?>
<?php include(APPPATH . 'Views/Components/headers.php'); ?>

<div class="container mt-5">
    <h1 class="text-center">Establecimientos</h1>

    <div class="row">
        <?php foreach ($establecimientos as $establecimiento): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $establecimiento['nombre_est'] ?></h5>
                        <p class="card-text">Dirección: <?= $establecimiento['direccion_est'] ?></p>
                        <p class="card-text">Teléfono: <?= $establecimiento['telefono_est'] ?></p>
         
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include(APPPATH . 'Views/Components/footer.php'); ?>
