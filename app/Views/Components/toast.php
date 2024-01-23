<!-- En tu vista -->
<?php if (isset($success)): ?>
    <div class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <?= $success ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<?php if (isset($errors)): ?>
    <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <?= implode('<br>', $errors) ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<!-- Agregar el siguiente script para activar los toasts -->
<script>
    var successToast = new bootstrap.Toast(document.querySelector('.toast.bg-success'));
    var errorToast = new bootstrap.Toast(document.querySelector('.toast.bg-danger'));

    <?php if (isset($success)): ?>
        successToast.show();
    <?php endif; ?>

    <?php if (isset($errors)): ?>
        errorToast.show();
    <?php endif; ?>
</script>
