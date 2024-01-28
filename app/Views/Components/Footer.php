<footer>
    <div class="container">
        <?php if (session()->has('username')) : ?>
            <p>Nombre del Usuario: <?= session('username') ?></p>
        <?php endif; ?>
    </div>
</footer>
