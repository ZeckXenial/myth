<?php if (isset($_SESSION['success']) && !empty($_SESSION['success'])): ?>
    <div class="toast mx-auto fixed-bottom" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
        <div class="toast-header ">
            <strong class="me-auto">Éxito</strong>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>

        </div>
        <div class="toast-body">
            <?= $_SESSION['success'] ?>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var successToastElement = document.querySelector('.toast');
            var successToast = new bootstrap.Toast(successToastElement);
            successToast.show();
        });
    </script>
<?php endif; ?>

<?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
    <div class="toast mx-auto fixed-bottom" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
        <div class="toast-header">
            <strong class="me-auto">Error</strong>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <?php
            if (is_array($_SESSION['errors'])) {
                foreach ($_SESSION['errors'] as $error) {
                    echo $error . '<br>';
                }
            } else {
                echo $_SESSION['errors'];
            }
            ?>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var errorToastElement = document.querySelector('.toast');
            var errorToast = new bootstrap.Toast(errorToastElement);
            errorToast.show();
        });
    </script>
<?php endif; ?>
