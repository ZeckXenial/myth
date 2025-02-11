<div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 11;">
    <?php 
    $toastType = '';
    $toastMessage = '';
    if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
        $toastType = 'success';
        $toastMessage = $_SESSION['success'];
    } elseif (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
        $toastType = 'error';
        $toastMessage = is_array($_SESSION['errors']) ? implode('<br>', $_SESSION['errors']) : $_SESSION['errors'];
    }

    if ($toastType): ?>
        <div class="toast mx-auto" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="toast-header">
                <strong class="me-auto"><?= ucfirst($toastType) ?></strong>
                <button type="button" class="btn-close me-2" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <?= $toastMessage ?>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var toastElement = document.querySelector('#toastContainer .toast');
                var toast = new bootstrap.Toast(toastElement);
                toast.show();
            });
        </script>
    <?php endif; ?>
</div>
