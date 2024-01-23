<footer>
    <div class="container">
        <p>&copy; <?= date('Y') ?>  <?= session('establecimiento') ?></p>
        <?php if (session()->has('username')) : ?>
            <p>Nombre del Usuario: <?= session('username') ?></p>
        <?php endif; ?>
    </div>
</footer>
