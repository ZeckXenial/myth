<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast success-toast bg-success" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
      
        </div>
    </div>
    <div class="toast error-toast bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
 
        </div>
    </div>
</div>
<script>
    var successToast = new bootstrap.Toast(document.querySelector('.success-toast'));
    var errorToast = new bootstrap.Toast(document.querySelector('.error-toast'));
   
    <?php if (isset($success)): ?>
        successToast.show();
    <?php endif; ?>

    <?php if (isset($errors)): ?>
        errorToast.show();
    <?php endif; ?>
   
      
</script>
