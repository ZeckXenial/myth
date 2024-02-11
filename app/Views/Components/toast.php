
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
